<?php

namespace App\Http\Controllers\Pajak;

use App\Models\Employee;
use App\Models\PublishFile;
use Illuminate\Support\Arr;
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
            'title' => 'Published Pajak',
            'published' => PublishFile::paginate(15),
        ]);
    }

    public function cariDataPajak(Request $request)
    {
        $isReset = request()->input('isReset');
        $isMetode2 = request()->input('isMetode2') ?? false;
        try {
            if ($isReset == 'true') {
                $this->jenisFormulir($request->id, true, false);
            } else {
                if ($isMetode2) {
                    $this->jenisFormulir($request->id, false, true);
                } else {
                    $this->jenisFormulir($request->id, false, false);
                }
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

    public function cariDataPajakAOne(Request $request)
    {
        $isReset = request()->input('isReset');
        $isMetode2 = request()->input('isMetode2') ?? false;
        try {
            if ($isReset == 'true') {
                $this->jenisFormulirAOne($request->id, true, false);
            } else {
                if ($isMetode2) {
                    $this->jenisFormulirAOne($request->id, false, true);
                } else {
                    $this->jenisFormulirAOne($request->id, false, false);
                }
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

    private function bulananPajak($id)
    {
        $publishedFile = PublishFile::find($id);
        $folderTargetBulan = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $publishedFile->folder_name . '/bupot_bulanan');
        $resultBulan = [];
        foreach ($folderTargetBulan as $bulan) {
            $getFile = Storage::disk('public')->path($bulan);
            // $getFile = Storage::disk('public')->path('files/shares/pajak/extrack/022024/bupot_bulanan/1502240000353_010613941424001_7b85a99a-a2f5-4d0d-aef7-73e1bda6afb9.pdf');
            $pdfParser = new Parser();
            $pdf = $pdfParser->parseFile($getFile);
            $content = $pdf->getPages()[0]->getDataTm();
            // dd($content);
            $resultBulan[] = [
                'publish_file_id' => $publishedFile->id,
                'file_path' => $publishedFile->folder_name . '/bupot_bulanan',
                'file_name' => File::basename($bulan),
                'file_identitas_npwp' => $content['23']['1'],
                'file_identitas_nik' => $content['51']['1'],
                'file_identitas_nama' => $content['24']['1'],
                'file_identitas_alamat' => $content['25']['1'],
            ];
        }
        // dd($resultBulan);
        $publishedFile->folder_jumlah_final = count($folderTargetBulan);
        $publishedFile->folder_status = true;
        $publishedFile->save();
        $bulanan = PublishFileNpwp::insert($resultBulan);

        return $bulanan;
    }

    private function finalPajak($id)
    {
        $publishedFile = PublishFile::find($id);
        $folderTargetBulan = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $publishedFile->folder_name . '/bupot_bulanan');
        $folderTargetTidakFinal = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $publishedFile->folder_name . '/bupot_final_tidakfinal');
        $resultFinal = [];
        foreach ($folderTargetTidakFinal as $final) {
            // 1302240000299_010613941424001_bb5d339f-b6c7-4749-aac7-bcf916a187dd.pdf
            $getFile = Storage::disk('public')->path($final);
            // $getFile   = Storage::disk('public')->path('files/shares/pajak/extrack/022024/bupot_final_tidakfinal/1302240000299_010613941424001_bb5d339f-b6c7-4749-aac7-bcf916a187dd.pdf');;
            $pdfParser = new Parser();
            $pdf = $pdfParser->parseFile($getFile);
            $content = $pdf->getPages()[0]->getDataTm();
            // dd($content);
            $resultFinal[] = [
                'publish_file_id' => $publishedFile->id,
                'file_path' => $publishedFile->folder_name . '/bupot_final_tidakfinal',
                'file_name' => File::basename($final),
                'file_identitas_npwp' => $content['25']['1'],
                'file_identitas_nik' => $content['57']['1'],
                'file_identitas_nama' => $content['26']['1'],
                'file_identitas_alamat' => $content['27']['1'],
            ];
        }
        // dd($resultBulan);
        $publishedFile->folder_jumlah_tidak_final = count($folderTargetTidakFinal);
        $publishedFile->folder_status = true;
        $publishedFile->save();
        $final = PublishFileNpwp::insert($resultFinal);

        return $final;
    }

    private function jenisFormulir($id, $isReset = false, $isMetode2 = false)
    {
        $isReset = $isReset;
        $isMetode2 = $isMetode2;
        $publishedFile = PublishFile::find($id);
        $searchDir = Storage::disk('public')->allDirectories('files/shares/pajak/extrack/' . $publishedFile->folder_name);
        $arrayDir = array_filter($searchDir, function ($value) use ($publishedFile) {
            return $value !== 'files/shares/pajak/extrack/' . $publishedFile->folder_name . '/bupot_tahunan';
        });
        $searchDir = array_filter($arrayDir);
        $files = [];
        foreach ($searchDir as $dir) {
            $files []= Storage::disk('public')->allFiles($dir);
        }
        $files = Arr::flatten($files);

        // $files = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $publishedFile->folder_name.'/bupot_bulanan/');
        // dd($files);
        // dd(array_merge($filesA,$filesB));
        $resultFormulir = [];
        foreach ($files as $file) {
            $getFile = Storage::disk('public')->path($file);
            $pdfParser = new Parser();
            $pdf = $pdfParser->parseFile($getFile);
            // $content       = $pdf->getPages()[0]->getDataTm();
            $content = $pdf->getText();
            // $squishContent = Str::of($pdf->getText())->squish();
            $resultFormulir[] = [
                'publish_file_id' => $publishedFile->id,
                'lokasi_formulir' => File::basename($file),
                'formulir' => $content,
            ];
        }
        // $employees = Employee::whereNotNull('npwp')->where('status_kepegawaian', 'Tetap')->orWhere('status_kepegawaian', 'Kontrak')->limit(275)->get();
        // $batchEmployees = Employee::whereNotNull('npwp')->where('status_kepegawaian', 'Tetap')->orWhere('status_kepegawaian', 'Kontrak')->get();
        $batchEmployees = Employee::whereNotNull('npwp')->whereNotNull('status_kepegawaian')->get();
        $filtered = [];
        $filterNpwp = '';
        // $employees = array_chunk($batchEmployees, 10, true);
        foreach ($batchEmployees->chunk(10) as $employees) {
            foreach ($employees as $employee) {
                // foreach ($resultFormulir as $key => $formulir) {
                //     $squishContent = Str::of($formulir['formulir'])->squish();
                //     if (Str::of($squishContent)->isMatch('/' . $employee->npwp . '/')) {
                //         $filtered[] = [
                //             'publish_file_id'     => $formulir['publish_file_id'],
                //             'file_path'           => $publishedFile->folder_name,
                //             'file_name'           => $formulir['lokasi_formulir'],
                //             'file_identitas_npwp' => $employee->npwp,
                //             'file_identitas_nik'  => $employee->nik,
                //             'file_identitas_nama' => $employee->nama,
                //         ];
                //         unset($resultFormulir[$key]);
                //         return $filtered;
                //     }
                // }
                $filterNpwp = Str::remove('/', $employee->npwp);
                $filterNpwp = Str::remove('-', $filterNpwp);
                $filterNpwp = Str::remove('.', $filterNpwp);
                if ($isMetode2) {
                    $filtered[] = $this->crawlingData($resultFormulir, $filterNpwp, $employee->nik, $employee->nama, $publishedFile->folder_name);
                } else {
                    $filtered[] = $this->crawlingData($resultFormulir, Str::remove('/', $employee->npwp), $employee->nik, $employee->nama, $publishedFile->folder_name);
                }
                $filterNpwp = '';
            }
        }
        // dd($filtered);
        $folderTarget = Storage::disk('public')->allDirectories('files/shares/pajak/extrack/' . $publishedFile->folder_name);
        $publishedFile->folder_jumlah_final = count(Storage::disk('public')->allFiles($folderTarget[0] ?? 0));
        $publishedFile->folder_jumlah_tidak_final = count(Storage::disk('public')->allFiles($folderTarget[1] ?? 0));
        $publishedFile->folder_jumlah_aone = count(Storage::disk('public')->allFiles($folderTarget[2] ?? 0));
        $publishedFile->folder_status = true;
        $publishedFile->save();
        try {
            if ($isReset) {
                // foreach ($filtered as $key => $filter) {
                // $final = PublishFileNpwp::upsert(
                //     [array_filter($filtered)],
                //     ['file_identitas_npwp'],
                //     ['publish_file_id','file_path', 'file_name', 'file_identitas_npwp', 'file_identitas_nik', 'file_identitas_nama']
                // );
                // }
                // $final = PublishFileNpwp::updateOrCreate(array_filter($filtered));
                PublishFileNpwp::where('publish_file_id', $publishedFile->id)->delete();
                PublishFileNpwp::insert(array_filter($filtered));
            } else {
                PublishFileNpwp::insert(array_filter($filtered));
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    // A1
    private function jenisFormulirAOne($id, $isReset = false, $isMetode2 = false)
    {
        $isReset = $isReset;
        $isMetode2 = $isMetode2;
        $publishedFile = PublishFile::find($id);
        $files = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $publishedFile->folder_name . '/bupot_tahunan/');
        $resultFormulir = [];
        foreach ($files as $file) {
            $getFile = Storage::disk('public')->path($file);
            $pdfParser = new Parser();
            $pdf = $pdfParser->parseFile($getFile);
            $content = $pdf->getText();
            $resultFormulir[] = [
                'publish_file_id' => $publishedFile->id,
                'lokasi_formulir' => File::basename($file),
                'formulir' => $content,
            ];
        }
        $batchEmployees = Employee::whereNotNull('npwp')->whereNotNull('status_kepegawaian')->get();
        $filtered = [];
        $filterNpwp = '';
        foreach ($batchEmployees->chunk(10) as $employees) {
            foreach ($employees as $employee) {
                $filterNpwp = Str::remove('/', $employee->npwp);
                $filterNpwp = Str::remove('-', $filterNpwp);
                $filterNpwp = Str::remove('.', $filterNpwp);
                if ($isMetode2) {
                    $filtered[] = $this->crawlingData($resultFormulir, $filterNpwp, $employee->nik, $employee->nama, $publishedFile->folder_name);
                } else {
                    $filtered[] = $this->crawlingData($resultFormulir, Str::remove('/', $employee->npwp), $employee->nik, $employee->nama, $publishedFile->folder_name);
                }
                $filterNpwp = '';
            }
        }

        try {
            if ($isReset) {
                PublishFileNpwp::where('publish_file_id', $publishedFile->id)->delete();
                PublishFileNpwp::insert(array_filter($filtered));
            } else {
                PublishFileNpwp::insert(array_filter($filtered));
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
    // END A1

    private function crawlingData(array $resultFormulir, $eNpwp, $eNik, $eNama, $publishedFileName)
    {
        $filtered = [];
        foreach ($resultFormulir as $key => $formulir) {
            $squishContent = Str::of($formulir['formulir'])->squish();
            if ($eNpwp == '') {
                $squishContent = '';

                return null;
            }
            if (Str::of($squishContent)->isMatch('/' . $eNpwp . '/')) {
                $filtered = [
                    'publish_file_id' => $formulir['publish_file_id'],
                    'file_path' => $publishedFileName,
                    'file_name' => $formulir['lokasi_formulir'],
                    'file_identitas_npwp' => $eNpwp,
                    'file_identitas_nik' => $eNik,
                    'file_identitas_nama' => $eNama,
                ];
                // unset($resultFormulir[$key]);
                $squishContent = '';
                break;
                // return $filtered;
            }
            $squishContent = '';

            // unset($filtered[$key]);
            // return null;
            // return $filtered;
        }

        return $filtered;
        // dd($filtered);
    }

    public function fileDataPajak(Request $request)
    {
        $published = PublishFile::with('hashPublished')->findOrFail(intval($request->input('file')));
        $title = 'Published Nama Pajak';
        $files = $published->hashPublished();
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
