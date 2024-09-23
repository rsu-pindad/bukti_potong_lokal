<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
// use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithUpserts;

class PegawaiBaruImport implements ToModel, WithHeadingRow, WithUpserts, WithChunkReading, WithBatchInserts, SkipsEmptyRows
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
            'npp'                => $row['npp_baru'] ?? $row['npp'],
            'npp_baru'           => $row['npp_baru'],
            'nama'               => $row['nama'],
            'status_kepegawaian' => $row['status_kepegawaian'],
            'nik'                => $row['nik'],
            'npwp'               => $row['npwp'],
            'status_ptkp'        => $row['status_ptkp'],
            'email'              => $row['email'],
            'no_hp'              => $row['no_hp'],
            'tmt_masuk'          => $row['tmt_masuk'],
            'tmt_keluar'         => $row['tmt_keluar'],
            'created_at'         => Carbon::now(),
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}
