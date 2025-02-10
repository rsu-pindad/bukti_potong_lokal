<?php

namespace App\Exports\Personalia;

use App\Models\Employee;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class EmployeeExport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements FromCollection, WithHeadings, ShouldAutoSize, WithColumnFormatting, WithCustomValueBinder
{
    public function collection()
    {
        $employee = Employee::select([
            'npp',
            'npp_baru',
            'nik',
            'nama',
            'status_ptkp',
            'status_kepegawaian',
            'npwp',
            'email',
            'no_hp',
            'tmt_masuk',
            'tmt_keluar'
        ])->get();
        return $employee;
    }

    public function headings(): array
    {
        return [
            'npp',
            'npp_baru',
            'nik',
            'nama',
            'status_ptkp',
            'status_kepegawaian',
            'npwp',
            'email',
            'no_hp',
            'epin',
            'tmt_masuk',
            'tmt_keluar'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_TEXT
        ];
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
