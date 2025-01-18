<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        $data = ['title' => 'Halaman Login Bukti Potong'];

        return view('guest.login', $data);
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $validator = Validator::make(
            $request->only(['username', 'password']),
            [
                'username' => 'required',
                'password' => 'required'
            ],
            [
                'username.required' => 'mohon isi username',
                'password.required' => 'mohon isi password'
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt($validator->safe()->only(['username', 'password']))) {
            Cache::flush();
            session()->regenerate();
        }

        return redirect()->back()->withErrors([
            'username' => 'Username atau Password salah',
        ])->onlyInput('username');
    }
}
