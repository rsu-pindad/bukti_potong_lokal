<?php

namespace App\Http\Controllers\Pajak;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\PublishFile;
use App\Models\PublishFileNpwp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser;

class PajakPublishedNikController extends Controller
{
    public function index()
    {
        return view('pajak.bukti-potong.pajak-published-file')->with([
            'title'     => 'Published Pajak',
            'published' => PublishFile::paginate(15),
        ]);
    }

    public function cariDataPajak(Request $request)
    {
        try {
            $result = $this->jenisFormulir($request->fileId);
            if ($result) {
                flash()
                    ->success('pencarian data selesai dilakukan')
                    ->flash();
            } else {
                flash()
                    ->warning($result)
                    ->flash();
            }
        } catch (\Throwable $th) {
            flash()
                ->warning($th->getMessage())
                ->flash();
        }

        return redirect()
                   ->back();
    }

    private function jenisFormulir($id)
    {
        $publishedFile = PublishFile::find($id);
        $searchDir     = Storage::disk('public')->allDirectories('files/shares/pajak/extrack/' . $publishedFile->folder_name);
        $files         = [];
        foreach ($searchDir as $dir) {
            $files[] = Storage::disk('public')->allFiles($dir);
        }
        $files          = Arr::flatten($files);
        $resultFormulir = [];
        foreach (array_chunk($files, 10) as $file) {
            foreach ($file as $f) {
                $getFile          = Storage::disk('public')->path($f);
                $pdfParser        = new Parser();
                $pdf              = $pdfParser->parseFile($getFile);
                $content          = $pdf->getText();
                $resultFormulir[] = [
                    'publish_file_id' => $publishedFile->id,
                    'lokasi_formulir' => File::basename($f),
                    // 'formulir'        => $content,
                    'formulirSquish'  => Str::of($content)->squish(),
                ];
            }
        }
        // dd($resultFormulir);
        $batchEmployees = Employee::select(['id', 'nik', 'nama', 'npwp'])->whereNotNull('status_kepegawaian')->get();
        $filtered       = [];
        foreach ($batchEmployees->chunk(10) as $employees) {
            foreach ($employees as $employee) {
                $filtered[] = $this->crawlingData($resultFormulir, $employee->nik, $employee->nama, $employee->npwp, $publishedFile->folder_name);
            }
        }
        // dd($filtered);
        $folderTarget = Storage::disk('public')->allDirectories('files/shares/pajak/extrack/' . $publishedFile->folder_name);

        $publishedFile->folder_jumlah_final       = count(Storage::disk('public')->allFiles($folderTarget[0] ?? 0));
        $publishedFile->folder_jumlah_tidak_final = count(Storage::disk('public')->allFiles($folderTarget[1] ?? 0));
        $publishedFile->folder_jumlah_aone        = count(Storage::disk('public')->allFiles($folderTarget[2] ?? 0));
        $publishedFile->folder_status             = true;
        $publishedFile->save();

        try {
            $dataFilter    = array_filter($filtered);
            $collectFilter = collect($dataFilter)->flatten(1)->toArray();

            return PublishFileNpwp::insert($collectFilter);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    private function crawlingData(array $resultFormulir, $eNik, $eNama, $eNpwp, $publishedFileName)
    {
        $filtered = [];
        foreach (array_chunk($resultFormulir, 10) as $formulir) {
            foreach ($formulir as $key => $value) {
                if ($eNik == '') {
                    return null;
                }
                $squishContent = Str::of($value['formulirSquish'])->contains($eNik);
                // if (Str::of($squishContent)->isMatch('/' . $eNik . '/')) {
                // $isContaints = Str::of();
                if ($squishContent) {
                    $filtered[] = [
                        'publish_file_id'     => $value['publish_file_id'],
                        'file_path'           => $publishedFileName,
                        'file_name'           => $value['lokasi_formulir'],
                        'file_identitas_npwp' => $eNpwp ?? null,
                        'file_identitas_nik'  => $eNik,
                        'file_identitas_nama' => $eNama,
                    ];
                    // break;
                }
                $squishContent = false;
            }
        }

        return $filtered;
    }

    public function fileDataPajak(Request $request)
    {
        $published = PublishFile::with('hashPublished')->findOrFail(intval($request->input('file')));
        $title     = 'Published Nama Pajak';
        $files     = $published->hashPublished();
        if ($request->input('file') && $cari = $request->input('cari')) {
            $files
                ->whereIn('publish_file_id', [$request->file])
                ->where(function ($query) use ($cari) {
                    $query
                        ->where('file_path', 'LIKE', "%{$cari}%")
                        ->orWhere('file_name', 'LIKE', "%{$cari}%")
                        ->orWhere('file_identitas_npwp', 'LIKE', "%{$cari}%")
                        ->orWhere('file_identitas_nik', 'LIKE', "%{$cari}%")
                        ->orWhere('file_identitas_nama', 'LIKE', "%{$cari}%");
                });
        }
        $files = $files->paginate(15);

        return view('pajak.bukti-potong.pajak-published-file-name', compact(['title', 'published', 'files']));
    }

    public function publishedCariFilePajak(Request $request)
    {
        $file = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $request->folder);
        if ($file) {
            $lokasi = Storage::disk('public')->allDirectories('files/shares/pajak/extrack/' . $request->folder);
            foreach ($lokasi as $key => $l) {
                $pathLokasi = Storage::disk('public')->exists($l . '/' . $request->filename);
                if ($pathLokasi) {
                    $pathLokasiFile = Storage::disk('public')->path($l . '/' . $request->filename);

                    return response()->file($pathLokasiFile);
                }
            }
        }
        flash()
            ->warning('terjadi kesalahan')
            ->flash();

        return redirect()
                   ->back();
    }
}
