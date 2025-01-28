<?php

namespace App\Http\Controllers\Personal;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use ZanySoft\Zip\Facades\Zip;
use ZanySoft\Zip\ZipManager;
use Illuminate\Support\Facades\DB;

class PersonalController extends Controller
{
    public function index(): View
    {
        return view('employee.beranda')->with([
            'profil' => User::with('employee')->find(auth()->id()),
        ]);
    }

    public function edit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => [
                'required',
                'email',
                Rule::unique('karyawan')->ignore(Auth::user()->karyawan->id),
            ],
            'nama'  => 'required',
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

    public function update(Request $request)
    {
        $validator = Validator::make($request->only('aggrement'), [
            'aggrement' => 'required|accepted'
        ], [
            'aggrement.required' => 'persetuan harus dicentang.'
        ]);

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
            $employee = DB::table('employees')
                            ->where('user_id', auth()->user()->employee->user_id)
                            ->update(['is_aggree' => true]);
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
