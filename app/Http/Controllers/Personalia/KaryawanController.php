<?php

namespace App\Http\Controllers\Personalia;

use App\Exports\Personalia\EmployeeExport;
use App\Http\Controllers\Controller;
use App\Imports\Personalia\PegawaiBaruImport;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class KaryawanController extends Controller
{s
    public function index(Request $request)
    {
        if (Auth::user()->hasRole('personalia')) {
            if ($cari = $request->input('cari')) {
                // $pegawai = new Employee();
                // $pegawai->where(function ($query) use ($cari) {
                // $query
                $pegawai = Employee::where('npp', 'LIKE', "%{$cari}%")
                               ->orWhere('npp_baru', 'LIKE', "%{$cari}%")
                               ->orWhere('nik', 'LIKE', "%{$cari}%")
                               ->orWhere('nama', 'LIKE', "%{$cari}%")
                               ->orWhere('email', 'LIKE', "%{$cari}%")
                               ->orWhere('no_hp', 'LIKE', "%{$cari}%")
                               ->orderBy('updated_at', 'DESC')
                               ->paginate(25);
                // });
            } else {
                $pegawai = Employee::orderBy('updated_at', 'DESC')->paginate(25);
            }
        } else {
            if ($cari = $request->input('cari')) {
                $pegawai = Employee::whereIn('status_kepegawaian', ['Tetap', 'Kontrak'])
                               ->where(function ($query) use ($cari) {
                                   $query
                                       ->orWhere('npp', 'LIKE', "%{$cari}%")
                                       ->orWhere('npp_baru', 'LIKE', "%{$cari}%")
                                       ->orWhere('nik', 'LIKE', "%{$cari}%")
                                       ->orWhere('nama', 'LIKE', "%{$cari}%")
                                       ->orWhere('npwp', 'LIKE', "%{$cari}%")
                                       ->orWhere('epin', 'LIKE', "%{$cari}%");
                               })
                               ->orderBy('updated_at', 'DESC')
                               ->paginate(25);
            } else {
                $pegawai = Employee::whereIn('status_kepegawaian')->orderBy('updated_at', 'DESC')->paginate(25);
            }
        }

        return view('karyawan.index')->with([
            'title'   => 'Data Pegawai',
            'pegawai' => $pegawai,
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'filePegawai' => 'required',
            // 'mulai'       => 'required',
            // 'akhir'       => 'required',
        ]);
        $mulai = $request->input('mulai');
        $akhir = $request->input('akhir');
        try {
            // Excel::import(new PegawaiBaruImport($mulai, $akhir), $request->file('filePegawai'));
            Excel::import(new PegawaiBaruImport(), $request->file('filePegawai'));
            flash()
                ->success('berhasil import data pegawai')
                ->flash();

            return redirect()
                       ->back();
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // flash()
            //     ->warning($th->getMessage())
            //     ->flash();

            // return redirect()
            //            ->back();
            $failures = $e->failures();

            foreach ($failures as $failure) {
                $failure->row();        // row that went wrong
                $failure->attribute();  // either heading key (if using heading row concern) or column index
                $failure->errors();     // Actual error messages from Laravel validator
                $failure->values();     // The values of the row that has failed.
            }
        }
    }

    public function export()
    {
        $filename = 'data_karyawan_pt_pmu_' . Carbon::now() . '.xlsx';

        return Excel::download(new EmployeeExport, $filename, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function template()
    {
        $pathLokasiFile = Storage::disk('public')->path('template/personalia/data_karyawan_pt_pmu_template.xlsx');

        return response()->download(
            $pathLokasiFile,
        );
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik'     => 'required|digits:16',
            'npp'     => 'required|digits:5',
            'npwp'    => 'nullable|min:15|unique:employees,npwp',
            'nama'    => 'required|min:3',
            'email'   => 'nullable|email:rfc,dns|unique:employees,email',
            'hp'      => 'nullable|unique:employees,no_hp',
            'st_ptkp' => 'required',
            'st_peg'  => 'required',
            'masuk'   => 'required|date',
            'keluar'  => 'nullable|date'
        ]);

        // $request->session()->reflash();

        if ($validator->fails()) {
            return redirect('karyawan')
                       ->withErrors($validator)
                       ->withInput();
        }

        try {
            $employee                     = new Employee;
            $employee->npp                = $validator->safe()->npp;
            $employee->nik                = $validator->safe()->nik;
            $employee->nama               = $validator->safe()->nama;
            $employee->npwp               = $validator->safe()->npwp;
            $employee->email              = $validator->safe()->email;
            $employee->no_hp              = $validator->safe()->hp;
            $employee->status_ptkp        = $validator->safe()->st_ptkp;
            $employee->status_kepegawaian = $validator->safe()->st_peg;
            $employee->tmt_masuk          = $validator->safe()->masuk == null ? null : Carbon::parse($validator->safe()->masuk)->format('d/m/Y');
            $employee->tmt_keluar         = $validator->safe()->keluar == null ? null : Carbon::parse($validator->safe()->keluar)->format('d/m/Y');
            $employee->save();
            flash()
                ->success('Data pegawai berhasil di tambahkan')
                ->flash();

            return redirect()
                       ->back();
        } catch (\Throwable $th) {
            flash()
                ->error($th->getMessage())
                ->flash();

            return redirect()->back()->withInput();
        }
    }

    public function edit(Request $request)
    {
        return view('karyawan.edit')->with([
            'title'   => 'Edit Data Pegawai',
            'pegawai' => Employee::find($request->id),
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npp' => 'required|digits:5',
            'npwp' => [
                'nullable',
                'min:15',
                Rule::unique('employees')->ignore($request->id),
            ],
            'nama' => 'required|min:3',
            'email' => [
                'nullable',
                'email:rfc,dns',
                Rule::unique('employees')->ignore($request->id),
            ],
            'no_hp' => [
                'nullable',
                Rule::unique('employees')->ignore($request->id),
            ],
            'st_ptkp' => 'required',
            'st_peg' => 'required',
            'masuk' => 'required|date',
            'keluar' => 'nullable|date'
        ]);
        if ($validator->fails()) {
            return redirect('karyawan')
                       ->withErrors($validator)
                       ->withInput();
        }

        try {
            $employee                     = Employee::find($request->id);
            $employee->npp                = $validator->safe()->npp;
            $employee->nama               = $validator->safe()->nama;
            $employee->npwp               = $validator->safe()->npwp;
            $employee->email              = $validator->safe()->email;
            $employee->no_hp              = $validator->safe()->no_hp;
            $employee->status_ptkp        = $validator->safe()->st_ptkp;
            $employee->status_kepegawaian = $validator->safe()->st_peg;
            $employee->tmt_masuk          = $validator->safe()->masuk == null ? null : Carbon::parse($validator->safe()->masuk)->format('d/m/Y');
            $employee->tmt_keluar         = $validator->safe()->keluar == null ? null : Carbon::parse($validator->safe()->keluar)->format('d/m/Y');
            $employee->save();
            flash()
                ->success('Data pegawai berhasil di perbarui')
                ->flash();

            return redirect('karyawan');
        } catch (\Throwable $th) {
            flash()
                ->error($th->getMessage())
                ->flash();

            return redirect()->back()->withInput();
        }
    }
}
