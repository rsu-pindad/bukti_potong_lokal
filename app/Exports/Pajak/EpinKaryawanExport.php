<?php

namespace App\Exports\Pajak;

use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromView;

class EpinKaryawanExport implements FromView
{
    public function view(): View
    {
        return view('personalia.exports.epin-employee')->with([
            'employees' => Employee::select([
                'npp',
                'npp_baru',
                'nik',
                'nama',
                'status_ptkp',
                'status_kepegawaian',
                'npwp',
                'epin'
            ])->where('status_kepegawaian', 'Tetap')
              ->orWhere('status_kepegawaian', 'Kontrak')
              ->get(),
        ]);
    }

    public function properties(): array
    {
        return [
            'creator'     => 'IT Pindad Medika',
            'title'       => 'Data Karyawan ' . Carbon::now(),
            'description' => 'Data Karyawan',
            'category'    => 'Data Karyawan',
            'manager'     => 'Sani Saftrizal',
            'company'     => 'PT Pindad Medika Utama',
        ];
    }
}
