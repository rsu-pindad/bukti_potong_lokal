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
    public function pdfParserSearch(Request $request)
    {
        if (!$request->hasValidSignature()) {
            notify()->error('Invalid signature.', 'Bukti Potong');

            return redirect()->back();
        }

        $validator = Validator::make($request->only(['bulan', 'tahun']), [
            'bulan' => 'required|numeric',
            'tahun' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()
                       ->back()
                       ->withErrors($validator)
                       ->withInput();
        }

        if (Auth::user()->karyawan->npwp == '') {
            notify()->warning('NPWP masih kosong', 'Bukti Potong');

            return redirect()
                       ->back();
        }

        $files = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_tahunan/');
        if (count($files) < 1) {
            notify()->warning('Bukti Potong A1 bulan ini belum diunggah', 'Bukti Potong');

            return redirect()
                       ->back();
        }
        $result = [];
        foreach ($files as $file) {
            $getFile   = Storage::disk('public')->path($file);
            $pdfParser = new Parser();
            $pdf       = $pdfParser->parseFile($getFile);
            $content   = $pdf->getText();

            if (str_contains($content, Str::remove('/', Auth::user()->karyawan->npwp))) {
                $result[] = File::basename($file);
                break;
            } else {
                $filterNpwp = Str::remove('/', Auth::user()->karyawan->npwp);
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
            notify()->warning('Bukti Potong A1 Anda belum ada', 'Bukti Potong');

            return redirect()
                       ->back();
        }
        try {
            return response()->file(Storage::disk('public')->path('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_tahunan/' . $result[0], 200));
        } catch (\Throwable $th) {
            notify()->error('Terjadi kendala.', 'Bukti Potong');
        }

        return redirect()
                   ->back();
    }

    public function downloadSearchPdf(Request $request)
    {
        if (!$request->hasValidSignature()) {
            return abort(401);
        }

        $validator = Validator::make($request->only(['bulan', 'tahun']), [
            'bulan' => 'required|numeric',
            'tahun' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return redirect()
                       ->back()
                       ->withErrors($validator)
                       ->withInput();
        }

        if (Auth::user()->karyawan->npwp == '') {
            notify()->warning('NPWP masih kosong.', 'Bukti Potong');

            return redirect()
                       ->back();
        }

        $files = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_tahunan/');
        if (count($files) < 1) {
            notify()->warning('Bukti Potong A1 bulan ini belum diunggah', 'Bukti Potong');

            return redirect()
                       ->back();
        }
        $result = [];
        foreach ($files as $file) {
            $getFile   = Storage::disk('public')->path($file);
            $pdfParser = new Parser();
            $pdf       = $pdfParser->parseFile($getFile);
            $content   = $pdf->getText();

            if (str_contains($content, Str::remove('/', Auth::user()->karyawan->npwp))) {
                $result[] = File::basename($file);
                break;
            } else {
                $filterNpwp = Str::remove('/', Auth::user()->karyawan->npwp);
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
            notify()->warning('Bukti Potong A1 Anda belum ada', 'Bukti Potong');

            return redirect()
                       ->back();
        }
        try {
            return response()->download(Storage::disk('public')->path('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_tahunan/' . $result[0], 200));
        } catch (\Throwable $th) {
            notify()->error('Terjadi kendala.', 'Bukti Potong');
        }

        return redirect()
                   ->back();
    }
}
