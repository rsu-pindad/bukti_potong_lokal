<?php

namespace App\Http\Controllers\Daftar;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class DaftarController extends Controller
{
    public function index(): View
    {
        return view('guest.daftar')->with([
            'route'    => 'daftar',
            'showSelf' => true,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:tbl_user|min:5|max:15',
            'password' => 'required|confirmed|min:6',
        ]);

        $request->session()->reflash();

        if ($validator->fails()) {
            return redirect('daftar')
                       ->withErrors($validator)
                       ->withInput();
        }

        try {
            $user           = new User;
            $user->username = $validator->safe()->username;
            $user->password = Hash::make($validator->safe()->password);
            $user->save();
            flash()
                ->success('akun berhasil di buat, silahkan masuk')
                ->flash();

            return redirect('login');
        } catch (\Throwable $th) {
            flash()
                ->error($th->getMessage())
                ->flash();

            return redirect()->back()->withInput();
        }
    }
}
