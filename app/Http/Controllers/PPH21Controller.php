<?php

namespace App\Http\Controllers;

use App\Exports\PPH21Export;
use App\Exports\PPH21DetailExport;
use App\Models\Gaji;
use App\Models\PPH21;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PPH21Controller extends Controller
{

    public function index()
    {
        // $month = PPH21::selectRaw('MONTH(tgl_pph21) as bulan')->groupBy(DB::raw('bulan'))->get();
        // $year = PPH21::selectRaw('YEAR(tgl_pph21) as tahun')->groupBy(DB::raw('tahun'))->get();
        // $year = PPH21::selectRaw('YEAR(tgl_pph21) as tahun')->groupBy(DB::raw('tahun'))->toSql();
        // dump($year);

        for ($i = 1; $i <= 12; $i++) {
            $month[] = ['bulan' => $i];
        }
        for ($i = 2023; $i <= Carbon::now()->year + 1; $i++) {
            $year[] = ['tahun' => $i];
        }

        $getPajak = request()->input('pajak') ?? "all";
        $getMonth = request()->input('month') ?? Carbon::now()->month;
        $getYear = request()->input('year') ?? Carbon::now()->year;

        $pph21 = [];
        if ($getPajak == 0) {
            $pph21 = PPH21::whereRaw("MONTH(tgl_pph21) = $getMonth AND YEAR(tgl_pph21) = $getYear AND pph21_sebulan = 0")->get();
        } elseif ($getPajak == 1) {
            $pph21 = PPH21::whereRaw("MONTH(tgl_pph21) = $getMonth AND YEAR(tgl_pph21) = $getYear AND pph21_sebulan > 0")->get();
        } else {
            $pph21 = PPH21::whereRaw("MONTH(tgl_pph21) = $getMonth AND YEAR(tgl_pph21) = $getYear")->get();
        }

        $data = [
            'title' => 'Data PPH21',
            'pph21' => $pph21,
            'year' => $year,
            'month' => $month,
            'getMonth' => $getMonth,
            'getYear' => $getYear,
            'getPajak' => $getPajak
        ];
        
        return view('pph21.index', $data);
    }

    public function show(PPH21 $pph21)
    {
        $tooltip = collect([
            'neto_sebulan' => "bruto - total potongan",
            'neto_setahun' => "neto sebulan * 12",
            'pkp' => "neto setahun - ptkp",
            'pph21_setahun' => "pkp < 60jt = pkp * 5% || pkp > 60jt & pkp < 250jt = 60jt*5% + (pkp-60jt)*15% || pkp > 250jt & pkp < 500jt = 60jt*5% + 250jt*15% + pkp * 25% || pkp > 500jt & pkp < 9999990000 = pkp * 35%",
            // 'pph21_sebulan' => "pph21 setahun / 12"
            'pph21_sebulan' => "Bruto bulan ini * TER Bulanan"
        ]);


        $data = ['title' => 'Detil Gaji', 'pph21' => $pph21, 'tooltip' => $tooltip];
        return view('pph21.detail', $data);
        // dd(PPH21::with('tbl_gaji')->first());
    }

    public function export(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');
        $pph21 = $request->get('pajak');
        if ($pph21 == 0) {
            $pph21 = false;
        } elseif ($pph21 == 1) {
            $pph21 = true;
        } else {
            $pph21 = 'all';
        }

        $fileName = $year . '_' . $month . '_' . 'pph21.xlsx';

        return Excel::download(new PPH21Export($month, $year, $pph21), $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function detailExport(Request $request){

        $now = Carbon::now('Asia/Jakarta');
        $files = $now . '_pph21.xlsx';

        $id = $request->id;

    //     return Excel::download(new PPH21DetailExport($id), $files, \Maatwebsite\Excel\Excel::CSV, [
    //         'Content-Type' => 'text/csv',
    //   ]);
        return Excel::download(new PPH21DetailExport($id), $files);
    }

    public function destroy(Request $request)
    {
        $getMonth = $request->input('month');
        $getYear = $request->input('year');

        PPH21::whereRaw("MONTH(tgl_gaji) = $getMonth AND YEAR(tgl_gaji) = $getYear")->delete();

        return back()->withToastSuccess("berhasil menghapus data bulan $getMonth tahun $getYear");
    }
}
