<?php

namespace App\Http\Controllers\Daftar;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class CariController extends Controller
{
    // public function __construct(Request $request)
    // {
    // }
    public function index(Request $request): View
    {
        // $request->session()->forget(['name', 'status']);
        $request->session()->invalidate();
        $request->session()->regenerate();

        return view('guest.daftar')->with([
            'route'    => 'cari',
            'showSelf' => false,
        ]);
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->only('npp'), [
            'npp' => 'required|numeric|min:5'
        ]);

        if ($validator->fails()) {
            return redirect('cari')
                       ->withErrors($validator)
                       ->withInput();
        }
        try {
            $employee = Employee::select([
                'id',
                'npp',
                'npp_baru',
                'nik',
                'nama',
                'npwp',
                'status_ptkp',
                'status_kepegawaian',
                'email',
                'no_hp',
                'epin',
                'is_taken',
                'is_active'
            ])->where('npp', $validator->safe()->npp)
              ->orWhere('npp_baru', $validator->safe()->npp)
              ->where('is_taken', false)
              ->where('is_active', false)
              ->first();
            if (!$employee) {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(10)
                    ->addError('npp tidak ditemukan');

                return redirect('cari');
            }
            // dd(count($karyawan));
            if ($employee->is_taken) {
                toastr()
                    ->closeOnHover(true)
                    ->closeDuration(10)
                    ->addError('npp sudah digunakan');

                return redirect('cari');
            }

            toastr()
                ->closeOnHover(true)
                ->closeDuration(10)
                ->addSuccess('npp ditemukan');
                
            $npp = $employee->npp;
            if ($npp == '') {
                $npp = $employee->npp_baru;
            }
            $request->session()->put('daftar_id', $employee->id);
            $request->session()->put('npp', $npp);
            $request->session()->put('nama', $employee->nama);
            $request->session()->put('nik', $employee->nik);
            $request->session()->put('npwp', $employee->npwp);
            $request->session()->put('email', $employee->email);
            $request->session()->put('no_hp', $employee->no_hp);
            $request->session()->put('status_ptkp', $employee->status_ptkp);
            $request->session()->put('status_kepegawaian', $employee->status_kepegawaian);
            $request->session()->put('epin', $employee->epin);

            return redirect('daftar')->withInput($request->input());
        } catch (\Throwable $th) {
            toastr()
                ->closeOnHover(true)
                ->closeDuration(10)
                ->addError($th->getMessage());

            return redirect('cari');
        }
    }
}
