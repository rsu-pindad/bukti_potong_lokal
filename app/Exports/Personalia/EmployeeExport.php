<?php

namespace App\Exports\Personalia;

use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithProperties;

class EmployeeExport implements FromView, WithProperties
{
    public function view(): View
    {
        return view('personalia.exports.employee')->with([
            'employees' => Employee::all(),
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
