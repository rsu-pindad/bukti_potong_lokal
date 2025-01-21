<?php

namespace App\Http\Controllers\Pajak;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\PublishFile;
use App\Models\PublishFileNpwp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser;
use YorCreative\UrlShortener\Services\UrlService;

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
        $isMetode2 = request()->input('isMetode2') ?? false;
        $result    = '';
        try {
            if ($isReset == 'true') {
                $dataPublish = PublishFileNpwp::where('publish_file_id', $request->id)->get()->toArray();
                foreach (array_chunk($dataPublish, 50) as $dp => $val) {
                    foreach ($val as $v) {
                        $dataUrl = UrlService::findByPlainText($v['original_link']);
                        if ($dataUrl) {
                            $dataUrl->forceDelete();
                        }
                    }
                }
                $cleanData = PublishFileNpwp::where('publish_file_id', $request->id)->delete();

                $result = $this->jenisFormulir($request->id, true, false);
            } else {
                if ($isMetode2) {
                    $result = $this->jenisFormulir($request->id, false, true);
                } else {
                    $result = $this->jenisFormulir($request->id, false, false);
                }
            }
            flash()
                // ->success('pencarian data selesai dilakukan')
                ->success($result)
                ->flash();
        } catch (\Throwable $th) {
            flash()
                ->warning($th->getMessage())
                ->flash();
        }

        return redirect()
                   ->back();
    }

    private function jenisFormulir($id, $isReset = false, $isMetode2 = false)
    {
        $isReset       = $isReset;
        $isMetode2     = $isMetode2;
        $publishedFile = PublishFile::find($id);
        $searchDir     = Storage::disk('public')->allDirectories('files/shares/pajak/extrack/' . $publishedFile->folder_name);
        $arrayDir      = array_filter($searchDir, function ($value) use ($publishedFile) {
            return $value !== 'files/shares/pajak/extrack/' . $publishedFile->folder_name . '/bupot_tahunan';
        });
        $searchDir     = array_filter($arrayDir);
        $files         = [];
        foreach ($searchDir as $dir) {
            $files[] = Storage::disk('public')->allFiles($dir);
        }
        $files          = Arr::flatten($files);
        $resultFormulir = [];
        foreach ($files as $file) {
            $getFile          = Storage::disk('public')->path($file);
            $pdfParser        = new Parser();
            $pdf              = $pdfParser->parseFile($getFile);
            $content          = $pdf->getText();
            $resultFormulir[] = [
                'publish_file_id' => $publishedFile->id,
                'lokasi_formulir' => File::basename($file),
                'formulir'        => $content,
            ];
        }
        $batchEmployees = Employee::whereNotNull('npwp')->whereNotNull('status_kepegawaian')->get();
        $filtered       = [];
        $filterNpwp     = '';
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
        $folderTarget = Storage::disk('public')->allDirectories('files/shares/pajak/extrack/' . $publishedFile->folder_name);

        try {
            $publishedFile->folder_jumlah_final       = count(Storage::disk('public')->allFiles($folderTarget[0])) ?? 0;
            $publishedFile->folder_jumlah_tidak_final = count(Storage::disk('public')->allFiles($folderTarget[1])) ?? 0;
            $publishedFile->folder_jumlah_aone        = count(Storage::disk('public')->allFiles($folderTarget[2])) ?? 0;
            $publishedFile->folder_status             = true;
            $publishedFile->save();

            $dataFilter = array_filter($filtered);
            // if ($isReset) {
            // foreach ($filtered as $key => $filter) {
            // $final = PublishFileNpwp::upsert(
            //     [array_filter($filtered)],
            //     ['file_identitas_npwp'],
            //     ['publish_file_id','file_path', 'file_name', 'file_identitas_npwp', 'file_identitas_nik', 'file_identitas_nama']
            // );
            // }
            // $final = PublishFileNpwp::updateOrCreate(array_filter($filtered));
            // $insertData = PublishFileNpwp::insert($dataFilter);
            // } else {
            $insertData = PublishFileNpwp::insert($dataFilter);

            // }
            return $insertData;
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function cariDataPajakAOne(Request $request)
    {
        $isReset   = request()->input('isReset');
        $isMetode2 = request()->input('isMetode2') ?? false;
        $result    = '';
        try {
            if ($isReset == 'true') {
                $result = $this->jenisFormulirAOne($request->id, true, false);
            } else {
                if ($isMetode2) {
                    $result = $this->jenisFormulirAOne($request->id, false, true);
                } else {
                    $result = $this->jenisFormulirAOne($request->id, false, false);
                }
            }
            flash()
                ->success($result)
                ->flash();
        } catch (\Throwable $th) {
            flash()
                ->warning($th->getMessage())
                ->flash();
        }

        return redirect()
                   ->back();
    }

    // Start A1

    private function jenisFormulirAOne($id, $isReset = false, $isMetode2 = false)
    {
        $isReset        = $isReset;
        $isMetode2      = $isMetode2;
        $publishedFile  = PublishFile::find($id);
        $files          = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $publishedFile->folder_name . '/bupot_tahunan/');
        $resultFormulir = [];
        foreach ($files as $file) {
            $getFile          = Storage::disk('public')->path($file);
            $pdfParser        = new Parser();
            $pdf              = $pdfParser->parseFile($getFile);
            $content          = $pdf->getText();
            $resultFormulir[] = [
                'publish_file_id' => $publishedFile->id,
                'lokasi_formulir' => File::basename($file),
                'formulir'        => $content,
            ];
        }
        $batchEmployees = Employee::whereNotNull('npwp')->whereNotNull('status_kepegawaian')->get();
        $filtered       = [];
        $filterNpwp     = '';
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
            // if ($isReset) {
            // PublishFileNpwp::where('publish_file_id', $publishedFile->id)->delete();
            // $dataFilter = array_filter($filtered);
            // PublishFileNpwp::updateOrCreate($dataFilter);
            // } else {
            $resultCreate = PublishFileNpwp::createMany(array_filter($filtered));

            return $resultCreate;
            // }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    // End A1

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
                $signedUrl     = URL::signedRoute('user-dokumen-pdf', [
                    'id'   => $formulir['publish_file_id'],
                    'name' => $formulir['lokasi_formulir'],
                ]);
                $shortUrl      = UrlService::shorten($signedUrl)
                                     ->withOpenLimit(10)
                                     ->withPassword($eNik)
                                     ->build();
                $filtered      = [
                    'publish_file_id'     => $formulir['publish_file_id'],
                    'file_path'           => $publishedFileName,
                    'file_name'           => $formulir['lokasi_formulir'],
                    'file_identitas_npwp' => $eNpwp,
                    'file_identitas_nik'  => $eNik,
                    'file_identitas_nama' => $eNama,
                    'short_link'          => $shortUrl,
                    'original_link'       => $signedUrl,
                ];
                $squishContent = '';
                break;
            }
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
