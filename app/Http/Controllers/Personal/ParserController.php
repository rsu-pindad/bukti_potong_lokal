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

    public function index()
    {
        return view('employee.berkas.berkas');
    }

    public function pdfParser(Request $request)
    {
        if (!$request->hasValidSignature()) {
            flash()
                ->warning('Signature Invalid')
                ->flash();
        }

        if(Auth::user()->employee->is_aggree == false){
            flash()
                ->error('Anda belum menyetujui kepegawain.')
                ->flash();

            return redirect()
                       ->back();
        }

        $target_bulan = $request->bulan_ini;

        if (Auth::user()->employee->npwp == '') {
            flash()
                ->warning('Maaf npwp masih kosong')
                ->flash();

            return redirect()
                       ->back();
        }

        $files = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $target_bulan);
        if ($files < 1) {
            flash()
                ->warning('Bukti Potong bulan ini belum di unggah')
                ->flash();
        }
        $result = [];
        foreach ($files as $file) {
            $getFile = Storage::disk('public')->path($file);
            // dd(File::basename($file));
            // $fileName = $file->getClientOriginalName();
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
                ->warning('Bukti Potong Anda belum ada')
                ->flash();

            return redirect()
                       ->back();
        }
        try {
            $filesExist   = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $target_bulan . '/bupot_final_tidakfinal/' . $result[0]);
            $dokumenPajak = '';
            if ($filesExist != true) {
                $filesExist   = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $target_bulan . '/bupot_bulanan/' . $result[0]);
                $dokumenPajak = response()->file(Storage::disk('public')->path('files/shares/pajak/extrack/' . $target_bulan . '/bupot_bulanan/' . $result[0], 200));
            } else {
                $dokumenPajak = response()->file(Storage::disk('public')->path('files/shares/pajak/extrack/' . $target_bulan . '/bupot_final_tidakfinal/' . $result[0], 200));
            }

            return $dokumenPajak;
        } catch (\Throwable $th) {
            // return abort(404);
            flash()
                ->warning('Bupot tidak ditemukan.')
                ->flash();

            return redirect()
                       ->back();
        }
    }

    public function pdfParserSearch(Request $request)
    {
        if (!$request->hasValidSignature()) {
            return abort(401);
        }

        if(Auth::user()->employee->is_aggree == false){
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

        $files = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun);
        if (count($files) < 1) {
            flash()
                ->warning('Bukti Potong bulan ini belum di unggah')
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
                ->warning('Bukti Potong Anda belum ada')
                ->flash();

            return redirect()
                       ->back();
        }
        try {
            $filesExist   = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_final_tidakfinal/' . $result[0]);
            $dokumenPajak = '';
            if ($filesExist != true) {
                $filesExist   = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_bulanan/' . $result[0]);
                $dokumenPajak = response()->file(Storage::disk('public')->path('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_bulanan/' . $result[0], 200));
            } else {
                $dokumenPajak = response()->file(Storage::disk('public')->path('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_final_tidakfinal/' . $result[0], 200));
            }

            return $dokumenPajak;
        } catch (\Throwable $th) {
            flash()
                ->warning('Bupot tidak ditemukan.')
                ->flash();

            return redirect()
                       ->back();
        }
    }

    public function downloadPdf(Request $request)
    {
        if (!$request->hasValidSignature()) {
            flash()
                ->warning('Signature Invalid')
                ->flash();
        }

        if(Auth::user()->employee->is_aggree == false){
            flash()
                ->error('Anda belum menyetujui kepegawain.')
                ->flash();

            return redirect()
                       ->back();
        }

        $target_bulan = $request->bulan_ini;

        if (Auth::user()->employee->npwp == '') {
            flash()
                ->warning('Maaf npwp masih kosong')
                ->flash();

            return redirect()
                       ->back();
        }

        $files = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $target_bulan);
        if ($files < 1) {
            flash()
                ->warning('Bukti Potong bulan ini belum di unggah')
                ->flash();
        }
        $result = [];
        foreach ($files as $file) {
            $getFile = Storage::disk('public')->path($file);
            // dd(File::basename($file));
            // $fileName = $file->getClientOriginalName();
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
                ->warning('Bukti Potong Anda belum ada')
                ->flash();

            return redirect()
                       ->back();
        }
        try {
            $filesExist   = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $target_bulan . '/bupot_final_tidakfinal/' . $result[0]);
            $dokumenPajak = '';
            if ($filesExist != true) {
                $filesExist   = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $target_bulan . '/bupot_bulanan/' . $result[0]);
                $dokumenPajak = response()->download(Storage::disk('public')->path('files/shares/pajak/extrack/' . $target_bulan . '/bupot_bulanan/' . $result[0], 200));
            } else {
                $dokumenPajak = response()->download(Storage::disk('public')->path('files/shares/pajak/extrack/' . $target_bulan . '/bupot_final_tidakfinal/' . $result[0], 200));
            }

            return $dokumenPajak;
        } catch (\Throwable $th) {
            // return abort(404);
            flash()
                ->warning('Bupot tidak ditemukan.')
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

        if(Auth::user()->employee->is_aggree == false){
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

        $files = Storage::disk('public')->allFiles('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun);
        if (count($files) < 1) {
            flash()
                ->warning('Bukti Potong bulan ini belum di unggah')
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
                ->warning('Bukti Potong Anda belum ada')
                ->flash();

            return redirect()
                       ->back();
        }
        try {
            $filesExist   = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_final_tidakfinal/' . $result[0]);
            $dokumenPajak = '';
            if ($filesExist != true) {
                $filesExist   = Storage::disk('public')->exists('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_bulanan/' . $result[0]);
                $dokumenPajak = response()->download(Storage::disk('public')->path('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_bulanan/' . $result[0], 200));
            } else {
                $dokumenPajak = response()->download(Storage::disk('public')->path('files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_final_tidakfinal/' . $result[0], 200));
            }

            return $dokumenPajak;
        } catch (\Throwable $th) {
            flash()
                ->warning('Bupot tidak ditemukan.')
                ->flash();

            return redirect()
                       ->back();
        }
    }
}
