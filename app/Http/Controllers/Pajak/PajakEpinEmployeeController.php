<?php

namespace App\Http\Controllers\Pajak;

use App\Exports\Pajak\EpinKaryawanExport;
use App\Http\Controllers\Controller;
use App\Imports\Pajak\EpinPegawaiImport;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Storage, Validator};
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class PajakEpinEmployeeController extends Controller
{
    public function edit(Request $request)
    {
        return view('pajak.employee.epin-edit')->with([
            'title'   => 'Edit Epin Pegawai',
            'pegawai' => Employee::find($request->id),
        ]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required',
            'epin' => 'required',
            'npwp' => [
                'nullable',
                'min:15',
                Rule::unique('employees')->ignore($request->id),
            ],
        ]);
        if ($validator->fails()) {
            return redirect('pajak-employee')
                       ->withErrors($validator)
                       ->withInput();
        }

        try {
            $employee       = Employee::find($request->id);
            $employee->epin = $validator->safe()->epin;
            $employee->save();
            flash()
                ->success('Data epin pegawai berhasil diperbarui')
                ->flash();

            return redirect('pajak-employee');
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
            'filePegawai' => 'required'
        ]);
        try {
            Excel::import(new EpinPegawaiImport, $request->file('filePegawai'));
            flash()
                ->success('berhasil import epin pegawai')
                ->flash();

            return redirect()
                       ->back();
        } catch (\Throwable $th) {
            flash()
                ->warning($th->getMessage())
                ->flash();

            return redirect()
                       ->back();
        }
    }

    public function export()
    {
        $filename = 'data_epin_karyawan_pt_pmu_' . Carbon::now() . '.xlsx';

        return Excel::download(new EpinKaryawanExport, $filename, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function template()
    {
        $pathLokasiFile = Storage::disk('public')->path('template/pajak/data_epin_karyawan_pt_pmu_template.xlsx');

        return response()->download(
            $pathLokasiFile,
        );
    }
}
