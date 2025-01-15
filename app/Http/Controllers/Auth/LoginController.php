<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class LoginController extends Controller
{
    public function index()
    {
        $data = ['title' => 'Halaman Login Bukti Potong'];

        return view('guest.login', $data);
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            Cache::flush();
            $request->session()->regenerate();

            $user = Auth::user();

            toastr()
                ->preventDuplicates(true)
                ->addSuccess('selamat datang ' . Auth::user()->username);

            if ($user->hasRole('pajak')) {
                return redirect()->intended(route('pajak-file-index'));
            }
            if ($user->hasRole('super-admin')) {
                return redirect()->intended(route('akses'));
            }
            if ($user->hasRole('personalia')) {
                return redirect()->intended(route('personalia-employee-index'));
            }

            return redirect()->intended(route('personal'));
        }
        $request->session()->reflash();

        return back()->withErrors([
            'username' => 'Username atau Password salah',
        ])->onlyInput('username');
    }
}
