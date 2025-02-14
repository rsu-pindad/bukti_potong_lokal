<?php

namespace App\Http\Controllers\Pajak;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\PublishFile;
use App\Models\PublishFileNpwp;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser;

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
        $isReset   = request()->input('isReset');
        try {
            if ($isReset == 'true') {
                $this->jenisFormulir($request->id, true);
            } else {
                $this->jenisFormulir($request->id, false);
            }
            flash()
                ->success('pencarian data selesai dilakukan')
                ->flash();

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

    private function jenisFormulir($id, $isReset = false)
    {
        $publishedFile = PublishFile::select(['id', 'folder_name'])->find($id);
        $searchFile = collect(Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $publishedFile->folder_name))->skip(1);
        $parser = new Parser();
        $resultFormulir = collect();
        $searchFile->filter(function (string $value, int $key) use ($parser, $publishedFile, $resultFormulir) {
            $pdf = $parser->parseFile(Storage::disk('public')->path($value));
            $resultFormulir[$key] = [
                'publish_file_id' => $publishedFile->id,
                'lokasi_formulir' => File::basename($value),
                'formulir'        => $pdf->getText(),
            ];
            return false;
        });
        $batchEmployees = Employee::whereNotNull('status_kepegawaian')->get();
        $chunks = $resultFormulir->chunk(10);
        $matchDocument = [];
        $x = collect();
        $x = $batchEmployees->each(function (object $employee, int $keyVal) use ($chunks, $matchDocument) {
            $matchDocument = $chunks->mapSpread(function (array $value, array $key) use ($employee) {
                // return collect($value)->values();
                $formulir = collect([$value]);
                $documents = $formulir->mapToGroups(function (array $item, int $keyItem) use ($employee) {
                    // if ($employee->npwp == null || $employee->nik == null) {
                    //     return [];
                    // }
                    // dd(Str::of($item['formulir'])->squish());
                    $squishContent = Str::of($item['formulir'])->squish();
                    // dd($batchEmployees);
                    // if (Str::of($squishContent)->isMatch('/' . $employee->npwp . '/')) {
                    //     $matchDocument[] = [
                    //         'publish_file_id'     => $item['publish_file_id'],
                    //         // 'file_path'           => $publishedFileName,
                    //         'file_name'           => $item['lokasi_formulir'],
                    //         'file_identitas_npwp' => $employee->npwp,
                    //         'file_identitas_nik'  => $employee->nik,
                    //         // 'file_identitas_nama' => $eNama,
                    //     ];
                    // }
                    return $squishContent;
                });
                // dd($documents);
                return collect(Arr::flatten($documents))->values();
            });
            // dd($matchDocument);
            return collect($matchDocument)->values();
        });
        dd($x);
        $filterChunk = $chunks->mapSpread(function (array $value, array $key) use ($batchEmployees) {
            $formulir = collect([$value]);
            $formulir->mapToGroups(function (array $item, int $keyItem) use ($batchEmployees) {
                // dd(Str::of($item['formulir'])->squish());
                $squishContent = Str::of($item['formulir'])->squish();
                // dd($batchEmployees);

            });
        });
        dd($filterChunk);
        $batchEmployees = Employee::whereNotNull('npwp')->whereNotNull('status_kepegawaian')->get();
        $filtered       = [];
        $filterNpwp     = '';
        foreach ($batchEmployees->chunk(10) as $employees) {
            foreach ($employees as $employee) {
                $filterNpwp = Str::remove('/', $employee->npwp);
                $filterNpwp = Str::remove('-', $filterNpwp);
                $filterNpwp = Str::remove('.', $filterNpwp);
                $filtered[] = $this->crawlingData($resultFormulir, $filterNpwp, $employee->nik, $employee->nama, $publishedFile->folder_name);

                $filterNpwp = '';
            }
        }
        $folderTarget                             = Storage::disk('public')->allDirectories('files/shares/pajak/extrack/' . $publishedFile->folder_name);
        $publishedFile->folder_jumlah_final       = count(Storage::disk('public')->allFiles($folderTarget[0] ?? null));
        $publishedFile->folder_jumlah_tidak_final = count(Storage::disk('public')->allFiles($folderTarget[1] ?? null));
        $publishedFile->folder_jumlah_aone        = count(Storage::disk('public')->allFiles($folderTarget[2] ?? null));
        $publishedFile->folder_status             = true;
        $publishedFile->save();
        try {
            if ($isReset) {
                PublishFileNpwp::where('publish_file_id', $publishedFile->id)->delete();
            } else {
                $dataFilter = array_filter($filtered);
                PublishFileNpwp::insert($dataFilter);
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    private function crawlingData(array $resultFormulir, $eNpwp, $eNik, $eNama, $publishedFileName)
    {
        $filtered = [];
        foreach ($resultFormulir as $key => $formulir) {
            $squishContent = Str::of($formulir['formulir'])->squish();
            // if ($eNpwp == '') {
            //     $squishContent = '';
            //     return null;
            // }
            if (Str::of($squishContent)->isMatch('/' . $eNpwp . '/')) {
                $filtered = [
                    'publish_file_id'     => $formulir['publish_file_id'],
                    'file_path'           => $publishedFileName,
                    'file_name'           => $formulir['lokasi_formulir'],
                    'file_identitas_npwp' => $eNpwp,
                    'file_identitas_nik'  => $eNik,
                    'file_identitas_nama' => $eNama,
                ];
                $squishContent = '';
                break;
            } elseif (Str::of($squishContent)->contains($eNik)) {
                $filtered = [
                    'publish_file_id'     => $formulir['publish_file_id'],
                    'file_path'           => $publishedFileName,
                    'file_name'           => $formulir['lokasi_formulir'],
                    'file_identitas_npwp' => $eNpwp,
                    'file_identitas_nik'  => $eNik,
                    'file_identitas_nama' => $eNama,
                ];
                $squishContent = '';
                break;
            }
            $filtered = [];
            $squishContent = '';
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
