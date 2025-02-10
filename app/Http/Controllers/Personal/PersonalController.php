<?php

namespace App\Http\Controllers\Personal;

use App\Models\Employee;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PersonalController extends Controller
{
    public function index(): View
    {
        return view('employee.beranda');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npwp' => [
                'required',
                'string',
                Rule::unique('employees')->ignore(Auth::user()->employee->id),
            ],
            'ptkp' => 'required',
            'st_peg' => 'required',
            'persetujuan' => 'accepted'
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
            $employee = Employee::find(Auth::user()->employee->id);
            $employee->is_edited = true;
            $employee->save();
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
