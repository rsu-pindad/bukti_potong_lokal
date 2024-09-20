<?php

namespace App\Http\Controllers\Pajak;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KaryawanController extends Controller
{
    public function index()
    {
        // $pegawai = Karyawan::where('user_id' ,'!=', Auth::id())->get();
        $pegawai = Employee::all();
        $data    = ['title' => 'Data Pegawai Baru', 'pegawai' => $pegawai];

        return view('karyawan.index', $data);
    }
}
