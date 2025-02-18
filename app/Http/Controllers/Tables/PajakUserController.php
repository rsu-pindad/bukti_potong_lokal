<?php

namespace App\Http\Controllers\Tables;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;

class PajakUserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(User::query()
                ->whereNot('username', 'pajak')
                ->whereNot('username', 'it')
                ->whereNot('username', 'personalia'))
                ->toJson();
        }

        return view('pajak.user.index');
    }
}
