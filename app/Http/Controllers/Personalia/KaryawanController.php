<?php

namespace App\Http\Controllers\Personalia;

use App\Http\Controllers\Controller;
use App\Imports\PegawaiBaruImport;
use App\Models\Employee;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class KaryawanController extends Controller
{
    public function index()
    {
        return view('karyawan.index')->with([
            'title' => 'Data Pegawai',
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
}
