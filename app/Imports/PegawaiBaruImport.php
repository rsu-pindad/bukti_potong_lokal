<?php

namespace App\Imports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;

class PegawaiBaruImport implements ToModel, WithHeadingRow, WithUpserts, WithChunkReading, SkipsEmptyRows
{
    use RemembersRowNumber;
    
    public function uniqueBy()
    {
        return 'nik';
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Employee([
            'npp'         => $row['npp'],
            'nik'         => $row['nik'],
            'npwp'        => $row['npwp'],
            'status_ptkp' => $row['status_ptkp'],
            'email'       => $row['email'],
            'no_hp'       => $row['no_hp']
        ]);
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
