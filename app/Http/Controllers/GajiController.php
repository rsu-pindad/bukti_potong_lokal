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
            dd($th);
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

    public function calculatePPH21New(Request $request)
    {
        $getMonth = $request->input('month') ?? Carbon::now()->month;
        $getYear = $request->input('year') ?? Carbon::now()->year;

        $gaji = Gaji::whereRaw("MONTH(tgl_gaji) = $getMonth AND YEAR(tgl_gaji) = $getYear")->get() ?? [];

        $dataPPH21 = [];
        $total_bruto = [];
        $bruto = [];
        $gross_bruto = [];
        $gross_up = [];
        $tunjangan_pajak_awal = 0;

        foreach ($gaji as $gj) {
            
            $t_tunja = $gj->tj_kelu + $gj->tj_kesja + $gj->tj_makan + $gj->tj_sostek + $gj->tj_kes + $gj->tj_dapen + $gj->tj_hadir;

            $total_bruto = $gj->gapok + $t_tunja + $tunjangan_pajak_awal;

            if(Carbon::parse($gj->tgl_gaji)->format('M') != 12 )
            {

                if($gj->st_ptkp == 'TK0' or $gj->st_ptkp == 'TK1' or $gj->st_ptkp == 'K0') // GOLONGAN A
                {
                    if ($gj->st_ptkp == 'TK0') {
                        $stPTKP = 54000000;
                    } elseif ($gj->st_ptkp == 'TK1') {
                        $stPTKP = 58500000;
                    } elseif ($gj->st_ptkp == 'K0') {
                        $stPTKP = 58500000;
                    }
                    if ($total_bruto >= 0 && $total_bruto <= 5400000)
                    {
                        $tarifpph21 = ($total_bruto * 0);
                        $gross_up = ($total_bruto + $tarifpph21) * 0; 
                    } 
                    elseif ($total_bruto > 5400000 && $total_bruto <= 5650000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.0025);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.0025;
                    } 
                    elseif ($total_bruto > 5650000 && $total_bruto <= 5950000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.005);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.005;
                    } 
                    elseif ($total_bruto > 5950000 && $total_bruto <= 6300000)
                    {
                        $tarifpph21 = ($total_bruto * 0.0075);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.0075;
                    } 
                    elseif ($total_bruto > 6300000 && $total_bruto <= 6750000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.01);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.01;
                    } 
                    elseif ($total_bruto > 6750000 && $total_bruto <= 7500000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.0125);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.0125;
                    } 
                    elseif ($total_bruto > 7500000 && $total_bruto <= 8550000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.015);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.015;
                        // $total_bruto += $tarifpph21;
                        // $gross_bruto = ($total_bruto * 0.015);
                    } 
                    elseif ($total_bruto > 8550000 && $total_bruto <= 9650000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.0175);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.0175;
                    }
                    elseif ($total_bruto > 9650000 && $total_bruto <= 10050000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.02);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.02;
                    }
                    elseif ($total_bruto > 10050000 && $total_bruto <= 10350000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.0225);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.0225;
                    }
                    elseif ($total_bruto > 10350000 && $total_bruto <= 10700000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.025);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.025;
                    }
                    elseif ($total_bruto > 10700000 && $total_bruto <= 11050000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.03);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.03;
                    }
                    elseif ($total_bruto > 11050000 && $total_bruto <= 11600000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.035);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.035;
                    }
                    elseif ($total_bruto > 11600000 && $total_bruto <= 12500000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.04);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.04;
                    }
                    elseif ($total_bruto > 12500000 && $total_bruto <= 13750000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.05);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.05;
                    }
                    elseif ($total_bruto > 13750000 && $total_bruto <= 15100000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.06);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.06;
                    }
                    elseif ($total_bruto > 15100000 && $total_bruto <= 16950000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.07);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.07;
                    }
                    elseif ($total_bruto > 16950000 && $total_bruto <= 19750000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.08);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.08;
                    }
                    elseif ($total_bruto > 19750000 && $total_bruto <= 24150000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.09);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.09;
                    }
                    elseif ($total_bruto > 24150000 && $total_bruto <= 26450000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.1);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.1;
                    }
                    elseif ($total_bruto > 26450000 && $total_bruto <= 28000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.11);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.11;
                    }
                    elseif ($total_bruto > 28000000 && $total_bruto <= 30050000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.12);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.12;
                    }
                    elseif ($total_bruto > 30050000 && $total_bruto <= 32400000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.13);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.13;
                    }
                    elseif ($total_bruto > 32400000 && $total_bruto <= 35400000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.14);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.14;
                    }
                    elseif ($total_bruto > 35400000 && $total_bruto <= 39100000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.15);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.15;
                    }
                    elseif ($total_bruto > 39100000 && $total_bruto <= 43850000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.16);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.16;
                    }
                    elseif ($total_bruto > 43850000 && $total_bruto <= 47800000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.17);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.17;
                    }
                    elseif ($total_bruto > 47800000 && $total_bruto <= 51400000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.18);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.18;
                    }
                    elseif ($total_bruto > 51400000 && $total_bruto <= 56300000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.19);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.19;
                    }
                    elseif ($total_bruto > 56300000 && $total_bruto <= 62200000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.2);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.2;
                    }
                    elseif ($total_bruto > 62200000 && $total_bruto <= 68600000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.21);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.21;
                    }
                    elseif ($total_bruto > 68600000 && $total_bruto <= 77500000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.22);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.22;
                    }
                    elseif ($total_bruto > 77500000 && $total_bruto <= 89000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.23);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.23;
                    }
                    elseif ($total_bruto > 89000000 && $total_bruto <= 103000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.24);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.24;
                    }
                    elseif ($total_bruto > 103000000 && $total_bruto <= 125000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.25);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.25;
                    }
                    elseif ($total_bruto > 125000000 && $total_bruto <= 157000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.26);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.26;
                    }
                    elseif ($total_bruto > 157000000 && $total_bruto <= 206000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.27);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.27;
                    }
                    elseif ($total_bruto > 206000000 && $total_bruto <= 337000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.28);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.28;
                    }
                    elseif ($total_bruto > 337000000 && $total_bruto <= 454000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.29);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.29;
                    }
                    elseif ($total_bruto > 454000000 && $total_bruto <= 550000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.3);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.3;
                    }
                    elseif ($total_bruto > 550000000 && $total_bruto <= 695000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.31);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.31;
                    }
                    elseif ($total_bruto > 695000000 && $total_bruto <= 910000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.32);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.32;
                    }
                    elseif ($total_bruto > 910000000 && $total_bruto <= 1400000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.33);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.33;
                    }
                    elseif ($total_bruto > 1400000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.34);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.34;
                    }
                }
                elseif($gj->st_ptkp == 'TK2' or $gj->st_ptkp == 'TK3' or $gj->st_ptkp == 'K1' or $gj->st_ptkp == 'K2') // GOLONGAN B
                {
                    if ($gj->st_ptkp == 'TK2') {
                        $stPTKP = 54000000;
                    } elseif ($gj->st_ptkp == 'TK3') {
                        $stPTKP = 58500000;
                    } elseif ($gj->st_ptkp == 'K1') {
                        $stPTKP = 63000000;
                    } elseif ($gj->st_ptkp == 'K2') {
			$stPTKP = 67500000;
		    }
                    if ($total_bruto >= 0 && $total_bruto <= 6200000 )
                    {
                        $tarifpph21 = ($total_bruto * 0);
                        $gross_up = ($total_bruto + $tarifpph21) * 0;
                    } 
                    elseif ($total_bruto > 6200000 && $total_bruto <= 6500000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.0025);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.0025;
                    } 
                    elseif ($total_bruto > 6500000 && $total_bruto <= 6850000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.005);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.005;
                    } 
                    elseif ($total_bruto > 6850000 && $total_bruto <= 7300000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.0075);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.0075;
                    } 
                    elseif ($total_bruto > 7300000 && $total_bruto <= 9200000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.01);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.01;
                    } 
                    elseif ($total_bruto > 9200000 && $total_bruto <= 10750000 ) 
                    {
                        $tarifpph21 = ($total_bruto * 0.015);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.015;
                    } 
                    elseif ($total_bruto > 10750000 && $total_bruto <= 11250000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.02);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.02;
                    } 
                    elseif ($total_bruto > 11250000 && $total_bruto <= 11600000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.025);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.025;
                    } 
                    elseif ($total_bruto > 11600000 && $total_bruto <= 12600000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.03);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.03;
                    } 
                    elseif ($total_bruto > 12600000 && $total_bruto <= 13600000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.04);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.04;
                    } 
                    elseif ($total_bruto > 13600000 && $total_bruto <= 14950000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.05);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.05;
                    } 
                    elseif ($total_bruto > 14950000 && $total_bruto <= 16400000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.06);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.06;
                    } 
                    elseif ($total_bruto > 16400000 && $total_bruto <= 18450000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.07);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.07;
                    } 
                    elseif ($total_bruto > 18450000 && $total_bruto <= 21850000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.08);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.08;
                    } 
                    elseif ($total_bruto > 21850000 && $total_bruto <= 26000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.09);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.09;
                    } 
                    elseif ($total_bruto > 26000000 && $total_bruto <= 27700000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.1);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.1;
                    } 
                    elseif ($total_bruto > 27700000 && $total_bruto <= 29350000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.11);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.11;
                    } 
                    elseif ($total_bruto > 29350000 && $total_bruto <= 31450000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.12);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.12;
                    } 
                    elseif ($total_bruto > 31450000 && $total_bruto <= 33950000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.13);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.13;
                    } 
                    elseif ($total_bruto > 33950000 && $total_bruto <= 37100000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.14);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.14;
                    } 
                    elseif ($total_bruto > 37100000 && $total_bruto <= 41100000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.15);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.15;
                    } 
                    elseif ($total_bruto > 41100000 && $total_bruto <= 45800000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.16);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.16;
                    } 
                    elseif ($total_bruto > 45800000 && $total_bruto <= 49500000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.17);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.17;
                    } 
                    elseif ($total_bruto > 49500000 && $total_bruto <= 53800000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.18);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.18;
                    } 
                    elseif ($total_bruto > 53800000 && $total_bruto <= 58500000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.19);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.19;
                    } 
                    elseif ($total_bruto > 58500000 && $total_bruto <= 64000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.2);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.2;
                    } 
                    elseif ($total_bruto > 64000000 && $total_bruto <= 71000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.21);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.21;
                    } 
                    elseif ($total_bruto > 71000000 && $total_bruto <= 80000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.22);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.22;
                    } 
                    elseif ($total_bruto > 80000000 && $total_bruto <= 93000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.23);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.23;
                    } 
                    elseif ($total_bruto > 93000000 && $total_bruto <= 109000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.24);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.24;
                    } 
                    elseif ($total_bruto > 109000000 && $total_bruto <= 129000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.25);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.25;
                    } 
                    elseif ($total_bruto > 129000000 && $total_bruto <= 163000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.26);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.26;
                    } 
                    elseif ($total_bruto > 163000000 && $total_bruto <= 211000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.27);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.27;
                    } 
                    elseif ($total_bruto > 211000000 && $total_bruto <= 374000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.28);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.28;
                    } 
                    elseif ($total_bruto > 374000000 && $total_bruto <= 459000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.29);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.29;
                    } 
                    elseif ($total_bruto > 459000000 && $total_bruto <= 555000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.3);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.3;
                    } 
                    elseif ($total_bruto > 555000000 && $total_bruto <= 704000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.31);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.31;
                    } 
                    elseif ($total_bruto > 704000000 && $total_bruto <= 957000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.32);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.32;
                    } 
                    elseif ($total_bruto > 957000000 && $total_bruto <= 1405000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.33);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.33;
                    } 
                    elseif ($total_bruto > 1405000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.34);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.33;
                    } 
                }
                elseif($gj->st_ptkp == 'K3') // GOLONGAN C
                {
                    $stPTKP = 54000000;
                    if ($total_bruto >= 0 && $total_bruto <= 6600000)
                    {
                        $tarifpph21 = ($total_bruto * 0);
                        $gross_up = ($total_bruto + $tarifpph21) * 0;
                    } 
                    elseif ($total_bruto > 6600000 && $total_bruto <= 6950000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.0025);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.0025;
                    } 
                    elseif ($total_bruto > 6950000 && $total_bruto <= 7350000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.005);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.005;
                    } 
                    elseif ($total_bruto > 7350000 && $total_bruto <= 7800000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.0075);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.0075;
                    } 
                    elseif ($total_bruto > 7800000 && $total_bruto <= 8850000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.01);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.01;
                    } 
                    elseif ($total_bruto > 8850000 && $total_bruto <= 9800000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.0125);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.0125;
                    } 
                    elseif ($total_bruto > 9800000 && $total_bruto <= 10950000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.015);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.015;
                    } 
                    elseif ($total_bruto > 10950000 && $total_bruto <= 11250000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.0175);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.0175;
                    } 
                    elseif ($total_bruto > 11250000 && $total_bruto <= 12050000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.02);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.02;
                    } 
                    elseif ($total_bruto > 12050000 && $total_bruto <= 12950000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.03);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.03;
                    } 
                    elseif ($total_bruto > 12950000 && $total_bruto <= 14150000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.04);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.04;
                    } 
                    elseif ($total_bruto > 14150000 && $total_bruto <= 15550000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.05);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.05;
                    } 
                    elseif ($total_bruto > 15550000 && $total_bruto <= 17050000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.06);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.06;
                    } 
                    elseif ($total_bruto > 17050000 && $total_bruto <= 19500000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.07);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.07;
                    } 
                    elseif ($total_bruto > 19500000 && $total_bruto <= 22700000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.08);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.08;
                    } 
                    elseif ($total_bruto > 22700000 && $total_bruto <= 26600000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.09);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.09;
                    } 
                    elseif ($total_bruto > 26600000 && $total_bruto <= 28100000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.1);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.1;
                    } 
                    elseif ($total_bruto > 28100000 && $total_bruto <= 30100000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.11);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.11;
                    } 
                    elseif ($total_bruto > 30100000 && $total_bruto <= 32600000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.12);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.12;
                    } 
                    elseif ($total_bruto > 32600000 && $total_bruto <= 35400000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.13);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.13;
                    } 
                    elseif ($total_bruto > 35400000 && $total_bruto <= 38900000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.14);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.14;
                    } 
                    elseif ($total_bruto > 38900000 && $total_bruto <= 43000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.15);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.15;
                    } 
                    elseif ($total_bruto > 43000000 && $total_bruto <= 47400000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.16);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.16;
                    } 
                    elseif ($total_bruto > 47400000 && $total_bruto <= 51200000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.17);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.17;
                    } 
                    elseif ($total_bruto > 51200000 && $total_bruto <= 55800000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.18);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.18;
                    } 
                    elseif ($total_bruto > 55800000 && $total_bruto <= 60400000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.19);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.19;
                    } 
                    elseif ($total_bruto > 60400000 && $total_bruto <= 66700000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.2);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.2;
                    } 
                    elseif ($total_bruto > 66700000 && $total_bruto <= 74500000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.21);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.21;
                    } 
                    elseif ($total_bruto > 74500000 && $total_bruto <= 83200000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.22);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.22;
                    } 
                    elseif ($total_bruto > 83200000 && $total_bruto <= 95600000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.23);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.23;
                    } 
                    elseif ($total_bruto > 95600000 && $total_bruto <= 110000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.24);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.24;
                    } 
                    elseif ($total_bruto > 110000000 && $total_bruto <= 134000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.25);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.25;
                    } 
                    elseif ($total_bruto > 134000000 && $total_bruto <= 169000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.26);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.26;
                    } 
                    elseif ($total_bruto > 169000000 && $total_bruto <= 221000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.27);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.27;
                    } 
                    elseif ($total_bruto > 221000000 && $total_bruto <= 390000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.28);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.28;
                    } 
                    elseif ($total_bruto > 390000000 && $total_bruto <= 463000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.29);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.29;
                    } 
                    elseif ($total_bruto > 463000000 && $total_bruto <= 561000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.3);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.3;
                    } 
                    elseif ($total_bruto > 561000000 && $total_bruto <= 709000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.31);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.31;
                    } 
                    elseif ($total_bruto > 709000000 && $total_bruto <= 965000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.32);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.32;
                    } 
                    elseif ($total_bruto > 965000000 && $total_bruto <= 1419000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.33);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.33;
                    } 
                    elseif ($total_bruto > 1419000000) 
                    {
                        $tarifpph21 = ($total_bruto * 0.34);
                        $gross_up = ($total_bruto + $tarifpph21) * 0.34;
                    } 
                }
            }

            $tunjangan_pajak_awal += $tarifpph21;

            $bool = false;
            do {
                $gapok = $gj->gapok;

                $tj_kelu = $gj->tj_kelu;
                $tj_kesja = $gj->tj_kesja;
                $tj_makan = $gj->tj_makan;
                $tj_sostek = $gj->tj_sostek;
                $tj_kes = $gj->tj_kes;
                $tj_dapen = $gj->tj_dapen;
                $tj_hadir = $gj->tj_hadir;

                $totalTunjangan = $gj->tj_kelu + $gj->tj_kesja + $gj->tj_makan + $gj->tj_sostek + $gj->tj_kes + $gj->tj_dapen + $gj->tj_hadir;
                $premiAS = 0;

                $tjPajak = $request->session()->get("pph21_$gj->npp");

                $bruto = round($total_bruto + $gross_up);

                $biayaJabatan = 500000;

                $iuranPensiun = $gj->pot_dapen ?? 0;

                $potongan = $gj->pot_sostek + $gj->pot_kes + $gj->pot_swk;

                $totalPotongan = $biayaJabatan + $iuranPensiun + $potongan;

                $netoSebulan = $bruto - $totalPotongan;

                $netoSetahun = $netoSebulan * 12;

                $ptkp = $stPTKP;

                $pkp = $netoSetahun - $stPTKP > 0 ? $netoSetahun - $stPTKP : 0;

                $pph21Setahun = $this->pph21_setahun($pkp);
                // $pph21Sebulan = $pph21Setahun / 12 > 0 ? $pph21Setahun / 12 : 0;
                $pph21Sebulan = round($tarifpph21);
                $request->session()->put("pph21_$gj->npp", $pph21Sebulan);

                if ($tjPajak == $pph21Sebulan) {
		    $tunjangan_pajak_awal = 0;
                    $bool = true;
                }
            } while ($bool == false);

            $dataPPH21 = [
                'id_gaji' => $gj->id,
                'tunjangan' => $totalTunjangan,
                'premi_as' => $premiAS,
                'tj_pajak' => round($gross_up),
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
                'pph21_sebulan' => round($gross_up),
                'tgl_pph21' => $gj->tgl_gaji,
            ];

            PPH21::updateOrCreate(['id_gaji' => $gj->id], $dataPPH21);

            // dd($dataPPH21);
        }

        if (count($gaji) < 1) {
            return back()->with('toast_error', 'pilih bulan & tahun terlebih dahulu untuk menghitung');
        }

        return redirect()
            ->route('pph21')
            ->withToastSuccess('berhasil menghitung pph21');
    }

}
