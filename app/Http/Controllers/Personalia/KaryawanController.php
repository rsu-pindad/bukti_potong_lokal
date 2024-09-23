<?php

namespace App\Http\Controllers\Personalia;

use App\Exports\Personalia\EmployeeExport;
use App\Http\Controllers\Controller;
use App\Imports\PegawaiBaruImport;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class KaryawanController extends Controller
{
    public function index()
    {
        return view('karyawan.index')->with([
            'title'   => 'Data Pegawai',
            'pegawai' => Employee::paginate(25),
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'filePegawai' => 'required'
        ]);
        try {
            Excel::import(new PegawaiBaruImport, $request->file('filePegawai'));
            flash()
                ->success('berhasil import data pegawai')
                ->flash();

            return redirect()
                       ->back();
        } catch (\Throwable $th) {
            flash()
                ->warning($th->getMessage())
                ->flash();

            return redirect()
                       ->back();
        }
    }

    public function export()
    {
        $filename = 'data_karyawan_pt_pmu_' . Carbon::now() . '.xlsx';

        return Excel::download(new EmployeeExport, $filename, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function template()
    {
        $pathLokasiFile = Storage::disk('public')->path('template/personalia/data_karyawan_pt_pmu_template.xlsx');

        return response()->download($pathLokasiFile, );
    }
}
