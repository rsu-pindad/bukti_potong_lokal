<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PersonalController extends Controller
{
    public function index()
    {
        if(!Auth::user()->employee){
            return 'Gagal mendapatkan profile, hubungi admin';
        }
        return view('employee.beranda');
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->only(['email', 'nama', 'notel']), [
            'email' => [
                'required',
                'email',
                Rule::unique('employees')->ignore(Auth::user()->employee->id),
            ],
            'nama' => 'required',
            'notel' => [
                'required',
                'numeric',
                Rule::unique('employees', 'no_tel')->ignore(Auth::user()->employee->id),
            ],
        ]);

        // $request->session()->reflash();

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $employee         = Employee::find(Auth::user()->employee->id);
            // $employee->nama   = $validator->safe()->nama;
            // $employee->email  = $validator->safe()->email;
            // $employee->no_hp = $validator->safe()->notel;
            $employee->is_setuju = true;
            $employee->save();
            flash()
                ->success('identitas pribadi berhasil diperbarui')
                ->flash();

            return redirect()->back();
        } catch (\Throwable $th) {
            flash()
                ->error($th->getMessage())
                ->flash();

            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->only(['npwp','ptkp','st_peg','persetujuan']), [
            'npwp' => [
                // 'required|numeric|unique:karyawan,npwp,except,id',
                'required',
                'string',
                Rule::unique('employees')->ignore(Auth::user()->employee->id),
            ],
            'ptkp' => 'required',
            'st_peg' => 'required',
            'persetujuan' => 'accepted'
        ]);

        // $request->session()->reflash();

        if ($validator->fails()) {
            flash()
                ->error('terjadi kesalahan validasi, mohon cek kembali')
                ->flash();

            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $employee = Employee::find(Auth::user()->employee->id);
            // $employee->npwp        = $validator->safe()->npwp;
            // $employee->st_ptkp     = $validator->safe()->ptkp;
            // $employee->st_peg      = $validator->safe()->st_peg;
            $employee->is_setuju = true;
            $employee->save();
            // flash()
            //     ->success('identitas pegawai berhasil diperbarui')
            //     ->flash();
            flash()
                ->success('form pencarian bukti potong terbuka')
                ->flash();

            return redirect()->back();
        } catch (\Throwable $th) {
            flash()
                ->error($th->getMessage())
                ->flash();

            return redirect()->back()->withInput();
        }
    }

    public function lihatDokumen(Request $request)
    {
        if (!$request->hasValidSignature()) {
            return abort(401);
        }
    }
}
