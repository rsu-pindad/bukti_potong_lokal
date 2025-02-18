<?php

namespace App\Http\Controllers\Pajak;

use App\Models\Employee;
use App\Models\PublishFile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;
use App\Models\PublishFileNpwp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PajakPublishedController extends Controller
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
        set_time_limit(300);
        try {
            $formula = $this->jenisFormulir($request->id);
            if (is_null($formula)) {
                flash()
                    ->success('pencarian berhasil dilakukan')
                    ->flash();
            } else {
                flash()
                    ->info($formula)
                    ->flash();
            }
            return redirect()
                ->back();
        } catch (\Throwable $th) {
            flash()
                ->warning($th->getMessage())
                ->flash();
            return redirect()
                ->back();
        }
    }

    private function jenisFormulir($id)
    {
        try {
            $publishedFile = PublishFile::select(['id', 'folder_name'])->find($id);
            $searchFile = collect(
                Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $publishedFile->folder_name)
                // )->skip(1);
            );
            $parser = new Parser();
            $resultFormulir = $searchFile->map(function (string $value, int $key) use ($parser, $publishedFile) {
                $paths = Storage::disk('public')->path($value);
                $pdf = $parser->parseFile($paths);
                return [
                    'publish_file_id' => $publishedFile->id,
                    'lokasi_formulir' => File::basename($value),
                    'formulir'        => $pdf->getText(),
                ];
            });
            $resultFormulirs = collect($resultFormulir);
            $batchEmployees = Employee::select([
                'id',
                'nama',
                'nik',
                'npwp',
                'status_kepegawaian'
            ])
                ->whereNotNull('nik')
                ->whereNotNull('status_kepegawaian')
                ->get();
            foreach ($batchEmployees->chunk(10) as $employees) {
                foreach ($employees as $employee) {
                    $this->crawlingData($resultFormulirs->all(), $employee, $publishedFile);
                }
            }
            // dd(array_filter($resultData));
            // if ($isReset) {
            //     PublishFileNpwp::where('publish_file_id', $publishedFile->id)->delete();
            // } else {
                $publishedFile->folder_status             = true;
                $publishedFile->folder_jumlah_file       = count($searchFile) ?? 0;
                $publishedFile->save();
            // }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    private function crawlingData(array $resultFormulirs, $employee, $publishedFileName)
    {
        $filtered = [];
        foreach ($resultFormulirs as $formulir) {
            $squishContent = Str::squish($formulir['formulir']);
            $slugs = $employee->nik;
            $slugs2 = $employee->npwp ?? 'BLM ADA NPWP';
            // $limitContent =  Str::limit($squishContent, 1600);
            if (Str::of($squishContent)->contains($slugs)) {
                PublishFileNpwp::insert([
                    'publish_file_id'     => $formulir['publish_file_id'],
                    'file_path'           => $publishedFileName->folder_name,
                    'file_name'           => $formulir['lokasi_formulir'],
                    'file_identitas_npwp' => $slugs2,
                    'file_identitas_nik'  => $slugs,
                    'file_identitas_nama' => $employee->nama,
                ]);
            } elseif (Str::of($squishContent)->contains($slugs2)) {
                PublishFileNpwp::insert([
                    'publish_file_id'     => $formulir['publish_file_id'],
                    'file_path'           => $publishedFileName->folder_name,
                    'file_name'           => $formulir['lokasi_formulir'],
                    'file_identitas_npwp' => $slugs2,
                    'file_identitas_nik'  => $slugs,
                    'file_identitas_nama' => $employee->nama,
                ]);
            } else {
                $filtered[] = [];
                // break;
            }
        }
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
