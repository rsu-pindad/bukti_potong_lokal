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
        $validator = Validator::make($request->all(), [
            'npp' => 'required|numeric|min:5'
        ]);

        if ($validator->fails()) {
            return redirect('cari')
                ->withErrors($validator)
                ->withInput();
        }
        try {
            $pegawai = Employee::where('npp', $validator->safe()->npp)
                ->orWhere('npp_baru', $validator->safe()->npp)
                ->first();
            if (!$pegawai) {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(10)
                    ->addError('npp tidak ditemukan');

                return redirect('cari');
            }
            if ($pegawai->user_id !== null) {
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

            $request->session()->put('npp', $validator->safe()->npp);
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
