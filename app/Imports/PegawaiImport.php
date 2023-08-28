<?php

namespace App\Imports;

use App\Models\Pegawai;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PegawaiImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Pegawai::updateOrCreate(
                ['npp' => $row['npp']],
                [
                    'npp'  => $row['npp'],
                    'nama' => $row['nama'],
                    'npwp' => $row['npwp'],
                ]
            );
        }
    }
}
