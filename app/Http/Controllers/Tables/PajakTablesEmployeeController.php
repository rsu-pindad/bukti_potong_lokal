<?php

namespace App\Http\Controllers\Tables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Employee;

class PajakTablesEmployeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(Employee::query())->toJson();
        }

        return view('pajak.employee.index');
    }
}
