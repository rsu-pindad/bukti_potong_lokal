<?php

namespace App\Http\Controllers;

use App\Exports\GajiExport;
use App\Imports\GajiImport;
use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\PPH21;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GajiController extends Controller
{
    public function index()
    {
        for ($i = 1; $i <= 12; $i++) {
            $month[] = ['bulan' => $i];
        }
        for ($i = 2023; $i <= Carbon::now()->year + 1; $i++) {
            $year[] = ['tahun' => $i];
        }

        $getMonth = request()->input('month') ?? Carbon::now()->month;
        $getYear = request()->input('year') ?? Carbon::now()->year;

        $gaji = Gaji::whereRaw("MONTH(tgl_gaji) = $getMonth AND YEAR(tgl_gaji) = $getYear")->get();

        $pegawai = Pegawai::all();

        $data = [
            'title' => 'Data Gaji Pegawai',
            'gaji' => $gaji,
            'year' => $year,
            'month' => $month,
            'getMonth' => $getMonth,
            'getYear' => $getYear,
            'pegawai' => $pegawai,
        ];
        return view('gaji.index', $data);
    }

    public function store(Request $request)
    {
        $getMonth = $request->input('month');
        $getYear = $request->input('year');

        $tglGaji = Carbon::createFromDate($getYear, $getMonth, 25)->format('Y-m-d');

        $validated = $request->validate([
            'npp' => 'required',
            'nama' => 'required',
            'st_ptkp' => 'required',
            'gapok' => 'numeric',
            'tj_kelu' => 'numeric',
            'tj_pend' => 'numeric',
            'tj_jbt' => 'numeric',
            'tj_kesja' => 'numeric',
            'tj_makan' => 'numeric',
            'tj_kes' => 'numeric',
            'tj_sostek' => 'numeric',
            'tj_dapen' => 'numeric',
            'tj_hadir' => 'numeric',
            'tj_lainnya' => 'numeric',
            'thr' => 'numeric',
            'bonus' => 'numeric',
            'lembur' => 'numeric',
            'kurang' => 'numeric',
            'pot_dapen' => 'numeric',
            'pot_sostek' => 'numeric',
            'pot_kes' => 'numeric',
            'pot_swk' => 'numeric',
        ]);

        $validated['tgl_gaji'] = $tglGaji;
        $validated['jm_potongan'] = $validated['pot_dapen'] + $validated['pot_sostek'] + $validated['pot_kes'] + $validated['pot_swk'];

        Gaji::updateOrCreate(['npp' => $validated['npp'], 'tgl_gaji' => $validated['tgl_gaji']], $validated);

        return back()->withToastSuccess('berhasil menambah data gaji');
    }

    public function show(Gaji $gaji)
    {
        $data = ['title' => 'Detil Gaji', 'gaji' => $gaji];
        return view('gaji.detail', $data);
    }

    public function destroy(Gaji $gaji)
    {
        $gaji->delete();
        return back()->withToastSuccess('berhasil menghapus data gaji');
    }

    public function export(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');

        $fileName = $year . '_' . $month . '_' . 'data_gaji.xlsx';
        return Excel::download(new GajiExport($month, $year), $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function import(Request $request)
    {
        $validated = $request->validate([
            'fileGaji' => 'required|file',
        ]);

        try {
            Excel::import(new GajiImport(), $validated['fileGaji']);
        } catch (\Throwable $th) {
            return back()->with('toast_error', 'Impor file yg benar');
        }

        return back()->withToastSuccess('berhasil mengimpor file gaji');
    }

    public function calculatePPH21(Request $request)
    {
        $getMonth = $request->input('month') ?? Carbon::now()->month;
        $getYear = $request->input('year') ?? Carbon::now()->year;

        $gaji = Gaji::whereRaw("MONTH(tgl_gaji) = $getMonth AND YEAR(tgl_gaji) = $getYear")->get() ?? [];

        $dataPPH21 = [];

        foreach ($gaji as $gj) {
            if ($gj->st_ptkp == 'TK0') {
                $stPTKP = 54000000;
            } elseif ($gj->st_ptkp == 'TK1') {
                $stPTKP = 58500000;
            } elseif ($gj->st_ptkp == 'TK2') {
                $stPTKP = 63000000;
            } elseif ($gj->st_ptkp == 'TK3') {
                $stPTKP = 67500000;
            } elseif ($gj->st_ptkp == 'K0') {
                $stPTKP = 58500000;
            } elseif ($gj->st_ptkp == 'K1') {
                $stPTKP = 63000000;
            } elseif ($gj->st_ptkp == 'K2') {
                $stPTKP = 67500000;
            } elseif ($gj->st_ptkp == 'K3') {
                $stPTKP = 72000000;
            }

            $bool = false;
            do {
                $gapok = $gj->gapok;

                $totalTunjangan = $gj->tj_kelu + $gj->tj_pend + $gj->tj_jbt + $gj->tj_alih + $gj->tj_kesja + $gj->tj_beras + $gj->tj_rayon + $gj->tj_makan + $gj->tj_dapen + $gj->tj_hadir + $gj->tj_bhy + $gj->thr + $gj->bonus + $gj->lembur + $gj->kurang + $gj->tj_lainnya;

                $premiAS = $gj->tj_kes + $gj->tj_sostek;

                $tjPajak = $request->session()->get("pph21_$gj->npp");

                $bruto = $gapok + $totalTunjangan + $gj->thr + $gj->bonus + $premiAS + $tjPajak;

                $biayaJabatan = 500000;

                $iuranPensiun = $gj->pot_dapen ?? 0;

                $potongan = $gj->pot_sostek + $gj->pot_kes + $gj->pot_swk;

                $totalPotongan = $biayaJabatan + $iuranPensiun + $potongan;

                $netoSebulan = $bruto - $totalPotongan;

                $netoSetahun = $netoSebulan * 12;

                $ptkp = $stPTKP;

                $pkp = $netoSetahun - $stPTKP > 0 ? $netoSetahun - $stPTKP : 0;

                $pph21Setahun = $this->pph21_setahun($pkp);
                $pph21Sebulan = $pph21Setahun / 12 > 0 ? $pph21Setahun / 12 : 0;
                $request->session()->put("pph21_$gj->npp", $pph21Sebulan);

                if ($tjPajak == $pph21Sebulan) {
                    $bool = true;
                }
            } while ($bool == false);

            $dataPPH21 = [
                'id_gaji' => $gj->id,
                'tunjangan' => $totalTunjangan,
                'premi_as' => $premiAS,
                'tj_pajak' => round($tjPajak),
                'bruto' => $bruto,
                'biaya_jabatan' => $biayaJabatan,
                'iuran_pensiun' => $iuranPensiun,
                'potongan' => $potongan,
                'total_potongan' => $totalPotongan,
                'neto_sebulan' => $netoSebulan,
                'neto_setahun' => $netoSetahun,
                'ptkp' => $ptkp,
                'pkp' => $pkp,
                'pph21_setahun' => $pph21Setahun,
                'pph21_sebulan' => round($pph21Sebulan),
                'tgl_pph21' => $gj->tgl_gaji,
            ];

            PPH21::updateOrCreate(['id_gaji' => $gj->id], $dataPPH21);
        }

        if (count($gaji) < 1) {
            return back()->with('toast_error', 'pilih bulan & tahun terlebih dahulu untuk menghitung');
        }

        return redirect()
            ->route('pph21')
            ->withToastSuccess('berhasil menghitung pph21');
    }

    private function pph21_setahun($pkp)
    {
        if ($pkp <= 60000000) {
            $pph21Setahun = $pkp * 0.05;
        } elseif ($pkp > 60000000 && $pkp <= 250000000) {
            $pph21Setahun = 60000000 * 0.05 + ($pkp - 60000000) * 0.15;
        } elseif ($pkp > 250000000 && $pkp <= 500000000) {
            $pph21Setahun = 60000000 * 0.05 + 190000000 * 0.15 + ($pkp - 250000000) * 0.25;
        } elseif ($pkp > 500000000 && $pkp <= 5000000000) {
            $pph21Setahun = 60000000 * 0.05 + 190000000 * 0.15 + 250000000 * 0.25 + ($pkp - 500000000) * 0.3;
        } elseif ($pkp > 5000000000 && $pkp <= 9999990000) {
            $pph21Setahun = 60000000 * 0.05 + 190000000 * 0.15 + 250000000 * 0.25 + 5000000000 * 0.3 + ($pkp - 5000000000) * 0.35;
        } else {
            $pph21Setahun = 0;
        }

        return $pph21Setahun;
    }
}
