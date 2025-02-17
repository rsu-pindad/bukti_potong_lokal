<?php

namespace App\Http\Controllers\Daftar;

use App\Http\Controllers\Controller;
use App\Models\Employee;
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
        $validator = Validator::make($request->only('npp'), [
            'npp' => 'required|min:5'
        ], [
            'npp.required' => 'mohon isi npp',
            'npp.min' => 'minimal 5 karakter',
        ]);

        if ($validator->fails()) {
            return redirect('cari')
                ->withErrors($validator)
                ->withInput();
        }
        try {
            session()->flush();
            $pegawai = Employee::where('npp_baru', $validator->safe()->npp)
                ->orWhere('npp', $validator->safe()->npp)
                ->first();
            if (!$pegawai) {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(10)
                    ->addError('npp tidak ditemukan');

                return redirect('cari');
            }
            if ($pegawai->is_taken) {
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
            $nppPegawai = $pegawai->npp_baru;
            if($nppPegawai == null){
                $nppPegawai = $pegawai->npp;
            }
            $request->session()->put('npp', $nppPegawai);
            $request->session()->put('nama', $pegawai->nama);
            $request->session()->put('nik', $pegawai->nik);
            $request->session()->put('npwp', $pegawai->npwp);
            $request->session()->put('email', $pegawai->email);
            $request->session()->put('no_hp', $pegawai->no_hp);
            $request->session()->put('status_ptkp', $pegawai->status_ptkp);
            $request->session()->put('status_kepegawaian', $pegawai->status_kepegawaian);
            $request->session()->put('epin', $pegawai->epin);

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
