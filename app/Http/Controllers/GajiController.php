<?php

namespace App\Http\Controllers;

use App\Imports\GajiImport;
use App\Models\Gaji;
use App\Models\PPH21;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class GajiController extends Controller
{

    public function index()
    {
        $month = Gaji::selectRaw('MONTH(tgl_gaji) as bulan')->groupBy(DB::raw('bulan'))->get();
        $year = Gaji::selectRaw('YEAR(tgl_gaji) as tahun')->groupBy(DB::raw('tahun'))->get();

        $getMonth = request()->input('month') ?? Carbon::now()->month;
        $getYear = request()->input('year') ?? Carbon::now()->year;

        $gaji = Gaji::whereRaw("MONTH(tgl_gaji) = $getMonth AND YEAR(tgl_gaji) = $getYear")->get();


        $data = [
            'title' => 'Data Gaji Pegawai', 'gaji' => $gaji,
            'year' => $year, 'month' => $month,
            'getMonth' => $getMonth, 'getYear' => $getYear
        ];
        return view('gaji.index', $data);
    }

    public function import_template()
    {
        return Storage::download('template_impor_gaji.xlsx');
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'fileGaji' => 'required|file'
        ]);

        try {
            Excel::import(new GajiImport, $validated['fileGaji']);
        } catch (\Throwable $th) {
            return dd($th);
        }

        return redirect()->route('gaji')->with('success', 'All good!');
    }

    public function calculatePPH21(Request $request)
    {

        $getMonth = $request->input('month') ?? Carbon::now()->month;
        $getYear = $request->input('year') ?? Carbon::now()->year;

        $gaji = Gaji::whereRaw("MONTH(tgl_gaji) = $getMonth AND YEAR(tgl_gaji) = $getYear")->get();

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

            $gapok = $gj->gapok;

            $totalTunjangan = $gj->tj_kelu + $gj->tj_pend + $gj->tj_jbt + $gj->tj_alih + $gj->tj_kesja + $gj->tj_beras + $gj->tj_rayon + $gj->tj_makan + $gj->tj_dapen + $gj->tj_hadir + $gj->tj_bhy + $gj->thr + $gj->bonus + $gj->lembur + $gj->kurang;

            $premiAS = $gj->tj_kes + $gj->tj_sostek;

            $tjPajak = $request->session()->pull("pph21_$gj->id");

            $bruto = $gapok + $totalTunjangan + $gj->thr + $gj->bonus + $premiAS + $tjPajak;

            $penghasilan = 0;

            $biayaJabatan = 500000;

            $iuranPensiun = $gj->pot_dapen;

            $potongan = $gj->pot_sostek + $gj->pot_kes  + $gj->pot_swk;

            $totalPenghasilan = $biayaJabatan + $iuranPensiun + $potongan;

            $netoSebulan = $bruto - $totalPenghasilan;


            $netoSetahun = $netoSebulan * 12;

            $ptkp = $stPTKP;

            $pkp = $netoSetahun - $stPTKP > 0 ? $netoSetahun - $stPTKP : 0;

            $pph21Setahun =  $this->pph21_setahun($pkp);
            $pph21Sebulan = $pph21Setahun / 12 > 0 ? $pph21Setahun / 12 : 0;


            $now = Carbon::now();

            $dataPPH21 = [
                'tgl_gaji' => $gj->tgl_gaji,
                'npp' => $gj->npp,
                'nama' => $gj->nama,
                'gapok' => $gj->gapok,
                'tunjangan' => $totalTunjangan,
                'premi_as' => $premiAS,
                'thr' => $gj->thr,
                'bonus' => $gj->bonus,
                'tj_pajak' => $tjPajak,
                'bruto' => $bruto,
                'penghasilan' => $penghasilan,
                'biaya_jabatan' => $biayaJabatan,
                'iuran_pensiun' => $iuranPensiun,
                'potongan' => $potongan,
                'ptkp' => $ptkp,
                'pkp' => $pkp,
                'pph21_setahun' => $pph21Setahun,
                'pph21_sebulan' => $pph21Sebulan,
                'created_at' => $now,
                'updated_at' => $now
            ];
            $request->session()->put("pph21_$gj->id", $pph21Sebulan);
            PPH21::updateOrCreate(['npp' => $gj->npp], $dataPPH21);
        }
        return redirect()->back()->with('success', 'berhasil menghitung pph21');
    }

    private function pph21_setahun($pkp)
    {
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

        return $pph21Setahun;
    }
}
