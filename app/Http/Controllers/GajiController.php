<?php

namespace App\Http\Controllers;

use App\Imports\GajiImport;
use App\Models\Gaji;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GajiController extends Controller
{

    public function index()
    {
        $month = Gaji::selectRaw('MONTH(bulan) as bulan')->groupBy(DB::raw('bulan'))->get();
        $year = Gaji::selectRaw('YEAR(bulan) as tahun')->groupBy(DB::raw('tahun'))->get();

        $getMonth = request()->input('month') ?? Carbon::now()->month;
        $getYear = request()->input('year') ?? Carbon::now()->year;

        $gaji = Gaji::whereRaw("MONTH(bulan) = $getMonth AND YEAR(bulan) = $getYear")->get();


        $data = [
            'title' => 'Data Gaji Pegawai', 'gaji' => $gaji,
            'year' => $year, 'month' => $month,
            'getMonth' => $getMonth, 'getYear' => $getYear
        ];
        return view('gaji.index', $data);
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'fileGaji' => 'required|file'
        ]);

        try {
            Excel::import(new GajiImport, $validated['fileGaji']);
        } catch (\Throwable $th) {
            return redirect()->route('gaji')->with('error', 'upload file gaji!');
        }

        return redirect()->route('gaji')->with('success', 'All good!');
    }

    public function calculatePPH21(Request $request)
    {

        $getMonth = $request->input('month') ?? Carbon::now()->month;
        $getYear = $request->input('year') ?? Carbon::now()->year;

        $gaji = Gaji::whereRaw("MONTH(bulan) = $getMonth AND YEAR(bulan) = $getYear")->get();

        $dataPPH21 = [];

        foreach ($gaji as $gj) {

            if ($gj->st_ptkp == "TK0") {
                $stPTKP = 54000000;
            } elseif ($gj->st_ptkp == "TK1") {
                $stPTKP = 58500000;
            } elseif ($gj->st_ptkp == "TK2") {
                $stPTKP = 63000000;
            } elseif ($gj->st_ptkp == "TK3") {
                $stPTKP = 67500000;
            } elseif ($gj->st_ptkp == "K0") {
                $stPTKP = 58500000;
            } elseif ($gj->st_ptkp == "K1") {
                $stPTKP = 63000000;
            } elseif ($gj->st_ptkp == "K2") {
                $stPTKP = 67500000;
            } elseif ($gj->st_ptkp == "K3") {
                $stPTKP = 72000000;
            }

            // print_r($request->session()->all());
            $ss =  $request->session()->put("tj_pajak_$gj->id", 0);
            echo $ss;
            // die;

            //pegawai
            $gapok = $gj->gapok;
            $tjBPJSKerja = $gapok * 0.0624;
            $tjBPJSKes = $gapok * 0.047253795;

            $totalTunjangan = $gj->tj_kelu + $gj->tj_jbt + $gj->tj_kesja + $gj->tj_profesi + $gj->tj_beras + $gj->tj_rayon + $gj->tj_didik + $gj->tj_bhy + $gj->tj_hadir + $gj->tj_alih + $gj->kurang;
            $premiAS = 0;
            $tjPajak = 0;
            $bruto = $gapok + $totalTunjangan + $premiAS + $tjPajak;
            $penghasilan = 0;
            $biayaJabatan = 500000;
            $iuranPenghasilan = 0;
            $totalPenghasilan = $biayaJabatan;
            $netoSebulan = $bruto - $totalPenghasilan;
            $netoSetahun = $netoSebulan * 12;
            $ptkp = $stPTKP;
            $pkp = $netoSetahun - $stPTKP > 0 ? $netoSetahun - $stPTKP : 0;



            // =IF(B16<=60000000,B16*0.05,IF(AND(B16>60000000,B16<=250000000),(60000000*0.05)+((B16-60000000)*0.15),IF(AND(B16>250000000,B16<=500000000),(60000000*0.05)+((250000000*0.15)+(B16*0.25)),IF(AND(B16>500000000,B16<=5000000000),(60000000*0.05)+((250000000*0.15)+(5000000000*0.25)+(B16*0.3)),IF(AND(B16>5000000000,B16<=9999990000),B16*35%,0)))))
            if ($pkp <= 60000000) {
                $pph21Setahun =  $pkp * 0.05;
            } elseif ($pkp > 60000000 && $pkp <= 250000000) {
                $pph21Setahun =  60000000 * 0.05 + ($pkp - 60000000) * 0.15;
            } elseif ($pkp > 250000000 && $pkp <= 500000000) {
                $pph21Setahun =  60000000 * 0.05 + ($pkp - 60000000) * 0.25;
            } elseif ($pkp > 500000000 && $pkp <= 5000000000) {
                $pph21Setahun =  60000000 * 0.05 + 250000000 * 0.15 + 5000000000 * 0.25 + $pkp * 0.3;
            } elseif ($pkp > 5000000000 && $pkp <= 9999990000) {
                $pph21Setahun =  $pkp * 0.35;
            } else {
                $pph21Setahun = 0;
            }
            $pph21Sebulan = $pph21Setahun / 12 > 0 ? $pph21Setahun / 12 : 0;

            $request->session()->put("tj_pajak_$gj->id");

            $dataPPH21[] = [
                'nama' => $gj->nama,
                'tunj' => $totalTunjangan,
                'tj_bpjs_kerja' => $tjBPJSKerja,
                'tj_bpjs_sehat' => $tjBPJSKes,
                'premi_as' => $premiAS,
                'tj_pajak' => 0,
                'bruto' => $bruto,
                'penghasilan' => $penghasilan,
                'iuran_penghasilan' => $iuranPenghasilan,
                'biaya_jabatan' => $biayaJabatan,
                'total_penghasilan' => $totalPenghasilan,
                'neto_sebulan' => $netoSebulan,
                'neto_setahun' => $netoSetahun,
                'ptpk' => $ptkp,
                'pkp' => $pkp,
                'pph21_setahun' => $pph21Setahun,
                'pph21_sebulan' => $pph21Sebulan,
            ];
        }

        echo "<pre>";
        print_r($dataPPH21);
        echo "</pre>";
        die;

        // $pph21Setahun1 =  60000000 * 0.05 + ((250000000 * 0.15) + (5000000000 * 0.25) + ($pkp * 0.3));
        // $pph21Setahun2 =  60000000 * 0.05 + 250000000 * 0.15 + 5000000000 * 0.25 + $pkp * 0.3;
        // echo $pph21Setahun1;
        // echo '<br>';
        // echo $pph21Setahun2;
    }
}
