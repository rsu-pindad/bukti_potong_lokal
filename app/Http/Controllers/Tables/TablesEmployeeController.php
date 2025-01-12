<?php

namespace App\Http\Controllers\Tables;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TablesEmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Employee::query())->toJson();
        }
        return view('personalia.employee.index');
    }

    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            Employee::find(request('id'))->delete();
            flash()
                ->success('berhasil hapus data pegawai')
                ->flash();
            return response()->json(['status' => 201, 'validasi' => null]);
        }
        return response()->json(['status' => 503]);
    }
}
