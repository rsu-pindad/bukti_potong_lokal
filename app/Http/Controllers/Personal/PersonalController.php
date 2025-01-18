<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use ZanySoft\Zip\Facades\Zip;
use ZanySoft\Zip\ZipManager;

class PersonalController extends Controller
{
    public function index(): View
    {
        return view('employee.beranda');
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->only(['nama', 'email', 'notel']), [
            'email' => [
                'required',
                'email',
                Rule::unique('karyawan')->ignore(Auth::user()->karyawan->id),
            ],
            'nama' => 'required',
            'notel' => [
                'required',
                'numeric',
                Rule::unique('karyawan', 'no_tel')->ignore(Auth::user()->karyawan->id),
            ],
        ]);

        if ($validator->fails()) {
            return redirect()
                       ->back()
                       ->withErrors($validator)
                       ->withInput();
        }

        try {
            $karyawan         = Karyawan::find(Auth::user()->karyawan->id);
            $karyawan->nama   = $validator->safe()->nama;
            $karyawan->email  = $validator->safe()->email;
            $karyawan->no_tel = $validator->safe()->notel;
            $karyawan->save();
            notify()->success('identitas pribadi berhasil diperbarui.', 'Bukti Potong');
        } catch (\Throwable $th) {
            notify()->error('Terjadi kendala.', 'Bukti Potong');
        }

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->only(['npwp', 'ptkp', 'st_peg', 'persetujuan']), [
            'npwp' => [
                // 'required|numeric|unique:karyawan,npwp,except,id',
                'required',
                'string',
                Rule::unique('karyawan')->ignore(Auth::user()->karyawan->id),
            ],
            'ptkp' => 'required',
            'st_peg' => 'required',
            'persetujuan' => 'accepted'
        ]);

        if ($validator->fails()) {
            return redirect()
                       ->back()
                       ->withErrors($validator)
                       ->withInput();
        }

        try {
            $karyawan              = Karyawan::find(Auth::user()->karyawan->id);
            $karyawan->user_edited = true;
            $karyawan->save();
            notify()->success('Form pencarian bukti potong terbuka', 'Bukti Potong');
        } catch (\Throwable $th) {
            notify()->error('Terjadi kendala', 'Bukti Potong');
        }

        return redirect()->back();
    }

    public function lihatDokumen(Request $request)
    {
        if (!$request->hasValidSignature()) {
            notify()->error('Signature invalid.', 'Bukti Potong');

            return redirect()->back();
        }
    }
}
