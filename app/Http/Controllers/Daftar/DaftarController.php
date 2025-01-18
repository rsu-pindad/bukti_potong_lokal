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
            'otp'      => 'required',
        ]);

        $request->session()->reflash();

        if ($validator->fails()) {
            return redirect('daftar')
                       ->withErrors($validator)
                       ->withInput();
        }
        if ($validator->safe()->otp != session()->get('otp')) {
            notify()->warning('OTP tidak sama', 'Form Daftar');

            return redirect()->back()->withInput();
        }

        try {
            $user           = new User;
            $user->username = $validator->safe()->username;
            $user->password = Hash::make($validator->safe()->password);
            $user->save();
            notify()->success('Akun berhasil dibuat', 'Form Daftar');

            return redirect('login');
        } catch (\Throwable $th) {
            notify()->error('Terjadi kendala', 'Form Daftar');
        }

        return redirect()->back()->withInput();
    }

    public function sendOtp()
    {
        $sendBlast = json_decode($this->sendWa(), true);
        $status    = $sendBlast['status'];
        // $status = false;
        if ($status == true) {
            notify()->success('OTP Berhasil dikirim', 'Form Daftar');

            return response()->json(['status' => 'terkirim'], 200);
        }
        notify()->warning('OTP Gagal dikirim', 'Form Daftar');

        return response()->json(['status' => 'gagal']);
    }

    private function sendWa()
    {
        $noHP      = session()->get('no_hp');
        $randomOTP = rand(1000, 9999);
        session()->put('otp', $randomOTP);
        $pesan = 'Bukti Potong OTP : ' . $randomOTP . PHP_EOL;
        $curl  = curl_init();

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
                'target'      => $noHP,
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
}
