<?php

namespace App\Http\Controllers\Daftar;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Karyawan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class CariController extends Controller
{
    public function index(): View
    {
        return view('guest.daftar')->with([
            'route'    => 'cari',
            'showSelf' => false,
        ]);
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npp' => 'required|numeric|min:5'
        ]);

        $request->session()->reflash();

        if ($validator->fails()) {
            return redirect('cari')
                       ->withErrors($validator)
                       ->withInput();
        }
        try {
            $pegawai = Employee::where('npp', $validator->safe()->npp)->first();
            if (!$pegawai) {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(10)
                    ->addError('npp tidak ditemukan');

                return redirect('cari');
            }
            $karyawan = Karyawan::where('npp', $pegawai->npp)->get();
            // dd(count($karyawan));
            if (count($karyawan) > 0) {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(10)
                    ->addError('npp sudah digunakan');

                return redirect('cari');
            }

            toastr()
                ->closeOnHover(true)
                ->closeDuration(10)
                ->addSuccess('npp ditemukan');

            // return redirect('daftar')->onlyInput('npp');
            // dd($validator->safe()->npp);
            $request->session()->put('npp', $validator->safe()->npp);
            $request->session()->put('nik', $pegawai->nik);
            $request->session()->put('npwp', $pegawai->npwp);
            $request->session()->put('email', $pegawai->email);
            $request->session()->put('no_hp', $pegawai->no_hp);
            $request->session()->put('status_ptkp', $pegawai->status_ptkp);

            // return redirect('daftar');
            return redirect('daftar')->withInput($request->input());
        } catch (\Throwable $th) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(10)
                ->addError($th->getMessage());

            return redirect('cari');
        }
    }
}
