<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Smalot\PdfParser\Parser;

class ParserController extends Controller
{
    public function pdfParser(Request $request)
    {
        if (!$request->hasValidSignature()) {
            return abort(401);
        }

        $files = Storage::allFiles('public/files/shares/pajak/extrack/012024');
        if ($files < 1) {
            return abort(404);
        }
        $result = [];
        foreach ($files as $file) {
            $getFile = Storage::path($file);
            // dd(File::basename($file));
            // $fileName = $file->getClientOriginalName();
            $pdfParser = new Parser();
            $pdf       = $pdfParser->parseFile($getFile);
            $content   = $pdf->getText();

            if (str_contains($content, Auth::user()->karyawan->npwp)) {
                $result[] = File::basename($file);
            }
        }
        try {
            $dokumenPajak = response()->file(storage_path('app/public/files/shares/pajak/extrack/012024/bupot_final_tidakfinal/' . $result[0], 200));

            return $dokumenPajak;
        } catch (\Throwable $th) {
            return abort(404);
        }
    }

    public function pdfParserSearch(Request $request)
    {
        if (!$request->hasValidSignature()) {
            return abort(401);
        }

        // dd($request->all());

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

        $files = Storage::allFiles('public/files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun);
        // dd($files);
        if (count($files) < 1) {
            flash()
                ->warning('Faktur Pajak tidak ditemukan')
                ->flash();

            return redirect()
                ->back();
        }
        $result = [];
        foreach ($files as $file) {
            $getFile   = Storage::path($file);
            $pdfParser = new Parser();
            $pdf       = $pdfParser->parseFile($getFile);
            $content   = $pdf->getText();

            if (str_contains($content, Auth::user()->karyawan->npwp)) {
                $result[] = File::basename($file);
            }
        }
        try {
            $dokumenPajak = response()->file(storage_path('app/public/files/shares/pajak/extrack/' . $validator->safe()->bulan . $validator->safe()->tahun . '/bupot_final_tidakfinal/' . $result[0], 200));

            return $dokumenPajak;
        } catch (\Throwable $th) {
            flash()
                ->warning($th->getMessage())
                ->flash();

            return redirect()
                ->back();
        }
    }
}
