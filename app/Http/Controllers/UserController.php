<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class UserController extends Controller
{
    public function import()
    {
        FacadesExcel::import(new UsersImport, 'user.dbf');

        return redirect('/')->with('success', 'All good!');
    }
}
