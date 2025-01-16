<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function index()
    {
        return view('guest.reset-password');
    }

    public function resetLink(Request $request)
    {
        $request->validate(['npp' => 'required']);

        try {
            $token = Str::random(64);

            $reset = DB::table('password_reset_tokens')->insert([
                'npp'        => $request->npp,
                'token'      => $token,
                'created_at' => Carbon::now()
            ]);

            $karyawan = Karyawan::where('npp', $request->npp)->first();
            if ($karyawan) {
                $this->sendWa($karyawan, $token);
            }
            flash()
                ->success('Password reset sudah dikirim.')
                ->flash();

            return to_route('login');
        } catch (\Throwable $th) {
            flash()
                ->warning($th->getMessage())
                // ->warning('Terjadi kendala.')
                ->flash();

            return redirect()
                       ->back();
        }
    }

    private function sendWa($karyawan, $token)
    {
        $url    = URL::temporarySignedRoute('auth-get-reset-password', now()->addMinutes(60), ['token' => $token]);
        $pesan  = 'Reset password link : ' . PHP_EOL;
        $pesan .= PHP_EOL;
        $pesan .= $url;
        $pesan .= PHP_EOL;
        $pesan .= 'Berlaku 60 menit' . PHP_EOL;
        $pesan .= 'atau 1x perubahan password' . PHP_EOL;
        $curl   = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target'      => $karyawan->no_tel,
                'message'     => $pesan,
                'delay'       => '5',
                'countryCode' => '62',
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . config('app.FONNTE')
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if (isset($error_msg)) {
            return $error_msg;
        }

        return $response;
    }

    public function resetPassword(Request $request, $token)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        return view('guest.reset-password-user', ['token' => $token]);
    }

    public function submitResetPassword(Request $request)
    {
        $request->validate([
            'password'              => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_reset_tokens')
                              ->where([
                                  'token' => request('token')
                              ])
                              ->first();

        if (!$updatePassword) {
            flash()
                ->warning('Token tidak valid')
                ->flash();

            return redirect()
                       ->back();
        }

        try {
            $karyawan = Karyawan::where('npp', $updatePassword->npp)->first();
            $user     = User::find($karyawan->user_id)
                            ->update(['password'               => Hash::make($request->password)]);
            DB::table('password_reset_tokens')->where(['token' => request('token')])->delete();

            flash()
                ->success('Update password berhasil.')
                ->flash();

            return to_route('login');
        } catch (\Throwable $th) {
            flash()
                // ->warning($th->getMessage())
                ->warning('Terjadi kendala.')
                ->flash();

            return redirect()
                       ->back();
        }
    }
}
