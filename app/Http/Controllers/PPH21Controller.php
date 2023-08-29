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
        $month = PPH21::selectRaw('MONTH(tgl_gaji) as bulan')->groupBy(DB::raw('bulan'))->get();
        $year = PPH21::selectRaw('YEAR(tgl_gaji) as tahun')->groupBy(DB::raw('tahun'))->get();

        $getMonth = request()->input('month') ?? Carbon::now()->month;
        $getYear = request()->input('year') ?? Carbon::now()->year;

        $pph21 = PPH21::whereRaw("MONTH(tgl_gaji) = $getMonth AND YEAR(tgl_gaji) = $getYear")->get();

        $data = [
            'title' => 'Data PPH21',
            'pph21' => $pph21,
            'year' => $year,
            'month' => $month,
            'getMonth' => $getMonth,
            'getYear' => $getYear
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
}
