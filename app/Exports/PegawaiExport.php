<?php

namespace App\Exports;

use App\Models\Pegawai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PegawaiExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $pegawai = Pegawai::all();
        $pegawai = $pegawai->map(function ($item, $key) {
            return collect($item)->except(['created_at', 'updated_at'])->toArray();
        });
        return $pegawai;
    }

    public function headings(): array
    {
        return [
            'No',
            'NPP',
            'Nama',
            'ST PTKP',
            'NPWP',
            'ST PEG'
        ];
    }
}
