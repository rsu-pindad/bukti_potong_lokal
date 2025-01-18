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

class ParserController extends Controller
{
    public function pdfParser(Request $request)
    {
        if (!$request->hasValidSignature()) {
            notify()->error('Signature Invalid', 'Bukti Potong');

            return redirect()->back();
        }

        $target_bulan = $request->bulan_ini;

        if (Auth::user()->karyawan->npwp == '') {
            notify()->warning('NPWP masih kosong.', 'Bukti Potong');

            return redirect()
                       ->back();
        }

        $files = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $target_bulan);
        if ($files < 1) {
            notify()->warning('Bukti Potong bulan ini belum diunggah.', 'Bukti Potong');

            return redirect()->back();
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
            notify()->warning('Bukti Potong Anda belum ada.', 'Bukti Potong');

            return redirect()
                       ->back();
        }
        try {
            $filesExist = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $target_bulan . '/bupot_final_tidakfinal/' . $result[0]);
            if ($filesExist) {
                return response()->file(Storage::disk('public')->path('files/shares/pajak/extrack/' . $target_bulan . '/bupot_final_tidakfinal/' . $result[0], 200));
            }
            $filesExist = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $target_bulan . '/bupot_bulanan/' . $result[0]);

            return response()->file(Storage::disk('public')->path('files/shares/pajak/extrack/' . $target_bulan . '/bupot_bulanan/' . $result[0], 200));
        } catch (\Throwable $th) {
            notify()->warning('Terjadi kendala.', 'Bukti Potong');
        }

        return redirect()
                   ->back();
    }

    public function pdfParserSearch(Request $request)
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
            notify()->warning('NPWP masih kosong', 'Bukti Potong');

            return redirect()
                       ->back();
        }

        $files = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun);
        if (count($files) < 1) {
            notify()->warning('Bukti Potong bulan ini belum diunggah', 'Bukti Potong');

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
            notify()->warning('Bukti Potong Anda belum ada.', 'Bukti Potong');

            return redirect()
                       ->back();
        }
        try {
            $filesExist = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_final_tidakfinal/' . $result[0]);
            if ($filesExist) {
                return response()->file(Storage::disk('public')->path('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_final_tidakfinal/' . $result[0], 200));
            }
            $filesExist = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_bulanan/' . $result[0]);

            return response()->file(Storage::disk('public')->path('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_bulanan/' . $result[0], 200));
        } catch (\Throwable $th) {
            notify()->warning('Terjadi kendala.', 'Bukti Potong');
        }

        return redirect()
                   ->back();
    }

    public function downloadPdf(Request $request)
    {
        if (!$request->hasValidSignature()) {
            notify()->warning('Signature invalid', 'Bukti Potong');

            return redirect()->back();
        }
        $target_bulan = $request->bulan_ini;
        if (Auth::user()->karyawan->npwp == '') {
            notify()->warning('NPWP masih kosong.', 'Bukti Potong');

            return redirect()
                       ->back();
        }

        $files = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $target_bulan);
        if ($files < 1) {
            notify()->warning('Bukti Potong bulan ini belum diunggah.', 'Bukti Potong');

            return redirect()->back();
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
            notify()->warning('Bukti Potong Anda belum ada.', 'Bukti Potong');

            return redirect()
                       ->back();
        }
        try {
            $filesExist = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $target_bulan . '/bupot_final_tidakfinal/' . $result[0]);

            if ($filesExist != true) {
                return response()->download(Storage::disk('public')->path('files/shares/pajak/extrack/' . $target_bulan . '/bupot_final_tidakfinal/' . $result[0], 200));
            }
            $filesExist = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $target_bulan . '/bupot_bulanan/' . $result[0]);

            return response()->download(Storage::disk('public')->path('files/shares/pajak/extrack/' . $target_bulan . '/bupot_bulanan/' . $result[0], 200));
        } catch (\Throwable $th) {
            notify()->error('Terjadi kendala.', 'Bukti Potong');
        }

        return redirect()
                   ->back();
    }

    public function downloadSearchPdf(Request $request)
    {
        if (!$request->hasValidSignature()) {
            notify()->error('Signature invalid', 'Bukti Potong');

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
            notify()->warning('NPWP masih kosong.', 'Bukti Potong');

            return redirect()
                       ->back();
        }

        $files = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun);
        if (count($files) < 1) {
            notify()->warning('Bukti Potong bulan ini belum diunggah.', 'Bukti Potong');

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
            notify()->warning('Bukti Potong Anda belum ada.', 'Bukti Potong');

            return redirect()
                       ->back();
        }
        try {
            $filesExist = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_final_tidakfinal/' . $result[0]);

            if ($filesExist != true) {
                return response()->download(Storage::disk('public')->path('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_final_tidakfinal/' . $result[0], 200));
            }
            $filesExist = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_bulanan/' . $result[0]);

            return response()->download(Storage::disk('public')->path('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_bulanan/' . $result[0], 200));
        } catch (\Throwable $th) {
            notify()->error('Terjadi kendala.', 'Bukti Potong');
        }

        return redirect()
                   ->back();
    }
}
