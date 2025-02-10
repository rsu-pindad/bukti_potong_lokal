<?php

namespace App\Http\Controllers\Personalia;

use App\Http\Controllers\Controller;
use App\Imports\Personalia\PersonaliaEmployeeImport;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Storage, Validator};
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Personalia\EmployeeExport;

class PersonaliaEmployeeController extends Controller
{
    public function destroy(Request $request, $id_karyawan)
    {
        try {
            if ($request->ajax()) {
                Employee::find($id_karyawan)->delete();

                return response()->json(['status' => 201, 'validasi' => null, 'message' => 'Data pegawai berhasil dihapus.']);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 503, 'message' => $th->getMessage()]);
        }
    }

    public function edit(Request $request)
    {
        return view('personalia.employee.edit')->with([
            'title'   => 'Edit Data Pegawai',
            'pegawai' => Employee::find($request->id),
        ]);
    }

    public function update(Request $request, $id_karyawan)
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
                // 'email:rfc,dns',
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
            return redirect('personalia-employee/edit/' . $id_karyawan)
                       ->withErrors($validator)
                       ->withInput();
        }

        try {
            $employee                     = Employee::find($id_karyawan);
            $employee->npp                = $validator->safe()->npp;
            $employee->nama               = $validator->safe()->nama;
            $employee->npwp               = $validator->safe()->npwp;
            $employee->email              = $validator->safe()->email;
            $employee->no_hp              = $validator->safe()->no_hp;
            $employee->status_ptkp        = $validator->safe()->st_ptkp;
            $employee->status_kepegawaian = $validator->safe()->st_peg;
            $employee->tmt_masuk          = $validator->safe()->masuk == null ? null : Carbon::parse($validator->safe()->masuk)->format('Y-m-d');
            $employee->tmt_keluar         = $validator->safe()->keluar == null ? null : Carbon::parse($validator->safe()->keluar)->format('Y-m-d');
            $employee->save();

            flash()
                ->success('Data pegawai berhasil diperbarui.')
                ->flash();

            return to_route('personalia-employee-index');
        } catch (\Throwable $th) {
            flash()
                ->error($th->getMessage())
                ->flash();

            return redirect()->back()->withInput();
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'filePegawai' => 'required',
        ]);
        try {
            Excel::import(new PersonaliaEmployeeImport(), $request->file('filePegawai'), 'public', \Maatwebsite\Excel\Excel::CSV);
            flash()
                ->success('berhasil import data pegawai')
                ->flash();

            return redirect()
                       ->back();
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
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
}
