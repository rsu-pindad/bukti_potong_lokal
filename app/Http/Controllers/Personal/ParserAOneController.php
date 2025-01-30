<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser;

class ParserAOneController extends Controller
{
    public function index()
    {
        return view('employee.berkas.berkasone');
    }

    public function pdfParserSearch(Request $request)
    {
        if (!$request->hasValidSignature()) {
            return abort(401);
        }

        if (Auth::user()->employee->is_aggree == false) {
            flash()
                ->error('Anda belum menyetujui kepegawain.')
                ->flash();

            return redirect()
                       ->back();
        }

        $validator = Validator::make($request->all(), [
            'bulan' => 'required|numeric',
            'tahun' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            flash()
                ->error('validasi error')
                ->flash();

            return redirect()
                       ->back()
                       ->withErrors($validator)
                       ->withInput();
        }

        if (Auth::user()->employee->npwp == '') {
            flash()
                ->warning('Maaf npwp masih kosong')
                ->flash();

            return redirect()
                       ->back();
        }

        $files = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_tahunan/');
        if (count($files) < 1) {
            flash()
                ->warning('Bukti Potong A1 bulan ini belum di unggah')
                ->flash();

            return redirect()
                       ->back();
        }
        $result = [];
        foreach ($files as $file) {
            $getFile   = Storage::disk('public')->path($file);
            $pdfParser = new Parser();
            $pdf       = $pdfParser->parseFile($getFile);
            $content   = $pdf->getText();

            if (str_contains($content, Str::remove('/', Auth::user()->employee->npwp))) {
                $result[] = File::basename($file);
                break;
            } else {
                $filterNpwp = Str::remove('/', Auth::user()->employee->npwp);
                $filterNpwp = Str::remove('-', $filterNpwp);
                $filterNpwp = Str::remove('.', $filterNpwp);
                if (str_contains($content, $filterNpwp)) {
                    $result[] = File::basename($file);
                    break;
                }
            }
        }
        $hasil = count($result);
        if ($hasil < 1) {
            flash()
                ->warning('Bukti Potong A1 Anda belum ada')
                ->flash();

            return redirect()
                       ->back();
        }
        try {
            $filesExist   = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_tahunan/' . $result[0]);
            $dokumenPajak = response()->file(Storage::disk('public')->path('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_tahunan/' . $result[0], 200));

            return $dokumenPajak;
        } catch (\Throwable $th) {
            flash()
                ->warning('Bupot A1 tidak ditemukan.')
                ->flash();

            return redirect()
                       ->back();
        }
    }

    public function downloadSearchPdf(Request $request)
    {
        if (!$request->hasValidSignature()) {
            return abort(401);
        }

        if (Auth::user()->employee->is_aggree == false) {
            flash()
                ->error('Anda belum menyetujui kepegawain.')
                ->flash();

            return redirect()
                       ->back();
        }

        $validator = Validator::make($request->all(), [
            'bulan' => 'required|numeric',
            'tahun' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            flash()
                ->error('validasi error')
                ->flash();

            return redirect()
                       ->back()
                       ->withErrors($validator)
                       ->withInput();
        }

        if (Auth::user()->employee->npwp == '') {
            flash()
                ->warning('Maaf npwp masih kosong')
                ->flash();

            return redirect()
                       ->back();
        }

        $files = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_tahunan/');
        if (count($files) < 1) {
            flash()
                ->warning('Bukti Potong A1 bulan ini belum di unggah')
                ->flash();

            return redirect()
                       ->back();
        }
        $result = [];
        foreach ($files as $file) {
            $getFile   = Storage::disk('public')->path($file);
            $pdfParser = new Parser();
            $pdf       = $pdfParser->parseFile($getFile);
            $content   = $pdf->getText();

            if (str_contains($content, Str::remove('/', Auth::user()->employee->npwp))) {
                $result[] = File::basename($file);
                break;
            } else {
                $filterNpwp = Str::remove('/', Auth::user()->employee->npwp);
                $filterNpwp = Str::remove('-', $filterNpwp);
                $filterNpwp = Str::remove('.', $filterNpwp);
                if (str_contains($content, $filterNpwp)) {
                    $result[] = File::basename($file);
                    break;
                }
            }
        }
        $hasil = count($result);
        if ($hasil < 1) {
            flash()
                ->warning('Bukti Potong A1 Anda belum ada')
                ->flash();

            return redirect()
                       ->back();
        }
        try {
            $filesExist   = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_tahunan/' . $result[0]);
            $dokumenPajak = '';
            $dokumenPajak = response()->download(Storage::disk('public')->path('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_tahunan/' . $result[0], 200));

            return $dokumenPajak;
        } catch (\Throwable $th) {
            flash()
                ->warning('Bupot A1 tidak ditemukan.')
                ->flash();

            return redirect()
                       ->back();
        }
    }
}
