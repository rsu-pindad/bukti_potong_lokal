<?php

namespace App\Http\Controllers;

use App\Exports\PPH21Export;
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
        $month = PPH21::selectRaw('MONTH(tgl_pph21) as bulan')->groupBy(DB::raw('bulan'))->get();
        $year = PPH21::selectRaw('YEAR(tgl_pph21) as tahun')->groupBy(DB::raw('tahun'))->get();

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

    public function export(Request $request)
    {
        $month = $request->get('month');
        $year = $request->get('year');

        $fileName = $year . '_' . $month . '_' . 'pph21.xlsx';

        return Excel::download(new PPH21Export($month, $year), $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function destroy(Request $request)
    {
        $getMonth = $request->input('month');
        $getYear = $request->input('year');

        PPH21::whereRaw("MONTH(tgl_gaji) = $getMonth AND YEAR(tgl_gaji) = $getYear")->delete();

        return redirect()->back()->withToastSuccess("berhasil menghapus data bulan $getMonth tahun $getYear");
    }
}
