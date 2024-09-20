<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        $data = ['title' => 'Halaman Login PPH21'];

        return view('auth.index', $data);
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            toastr()
                ->preventDuplicates(true)
                ->addSuccess('selamat datang '.Auth::user()->username);

            if($user->hasRole('pajak')){
                return redirect()->intended('gaji');   
            }
            if($user->hasRole('super-admin')){
                return redirect()->intended('akses');   
            }
            if($user->hasRole('personalia')){
                return redirect()->intended('karyawan');   
            }
            // dd($user);
            return redirect()->intended('employee');
        }

        return back()->withErrors([
            'username' => 'Username atau Password salah',
        ])->onlyInput('username');
    }
}
