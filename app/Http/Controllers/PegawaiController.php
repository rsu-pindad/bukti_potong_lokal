<?php

namespace App\Http\Controllers;

use App\Exports\PegawaiExport;
use App\Imports\PegawaiImport;
use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PegawaiController extends Controller
{
    public function index()
    {
        $pegawai = Pegawai::all();
        $data = ['title' => 'Data Pegawai', 'pegawai' => $pegawai];

        return view('pegawai.index', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'npp' => 'required',
            'nama' => 'required',
            'npwp' => 'required',
            'st_ptkp'=>'required',
            'st_peg'=>'required',
        ]);
        Pegawai::updateOrCreate(['npp' => $validated['npp']], $validated);

        return redirect()->back()->withToastSuccess('berhasil memperbarui data pegawai');
    }

    public function import(Request $request)
    {
        $request->validate([
            'filePegawai' => 'required'
        ]);
        try {
            Excel::import(new PegawaiImport, $request->file('filePegawai'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('toast_error', 'upload file yang benar!');
        }
        return redirect()->back()->withToastSuccess('berhasil memperbarui data pegawai');
    }

    public function export()
    {
        $fileName = Carbon::now() . '_' . 'pegawai.xlsx';
        return Excel::download(new PegawaiExport, $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }
}
