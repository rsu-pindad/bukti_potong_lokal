<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EmployeeController extends Controller
{
    public function index(): View
    {
        return view('employee.beranda');
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        $request->session()->reflash();

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
            $karyawan              = Karyawan::find(Auth::user()->karyawan->id);
            $karyawan->npwp        = $validator->safe()->npwp;
            $karyawan->st_ptkp     = $validator->safe()->ptkp;
            $karyawan->st_peg      = $validator->safe()->st_peg;
            $karyawan->user_edited = true;
            $karyawan->save();
            flash()
                ->success('identitas pegawai berhasil diperbarui')
                ->flash();

            return redirect()->back();
        } catch (\Throwable $th) {
            flash()
                ->error($th->getMessage())
                ->flash();

            return redirect()->back()->withInput();
        }
    }

    public function editPribadi(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        $request->session()->reflash();

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

    public function lihatDokumen(Request $request)
    {
        if (!$request->hasValidSignature()) {
            return abort(401);
        }

        // return view('employee.dokumen');
        // $locationZip = storage_path('app/public/files/shares/pajak/template_penilaian.zip');
        // $is_valid = Zip::open($locationZip);
        // $manager = new ZipManager;
        // $manager->addZip(Zip::open(storage_path('app/public/files/shares/pajak/template_penilaian.zip')));
        // $extract = $manager->extract(storage_path('app/public/files/shares/pajak/extrack'), true);
        // $manager->close();

        // try {
        //     $file = response()->file(storage_path('app/public/files/shares/pajak/extrack/template_penilaian.pdf', 200));
        //     return $file;
        // } catch (\Throwable $th) {
        //     return abort(404);
        // }
    }
}
