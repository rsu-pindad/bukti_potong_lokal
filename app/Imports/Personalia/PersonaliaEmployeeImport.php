<?php

namespace App\Imports\Personalia;

use App\Models\Employee;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\RemembersChunkOffset;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;

class PersonaliaEmployeeImport extends StringValueBinder implements ToModel, WithUpserts, WithBatchInserts, WithStartRow, WithCustomValueBinder
{
    use RemembersChunkOffset;

    public function model(array $row)
    {
        return new Employee([
            'npp'                => $row[0],
            'npp_baru'           => ($row[1] != null) ? $row[1] : null,
            'nama'               => $row[2],
            'status_kepegawaian' => $row[3],
            'nik'                => $row[4],
            'npwp'               => ($row[5] != null) ? $row[5] : null,
            'status_ptkp'        => $row[6],
            'email'              => $row[7],
            'no_hp'              => $row[8],
            'tmt_masuk'          => ($row[9] != null) ? Carbon::createFromFormat('Y-m-d', $row[9])->format('Y-m-d') : null,
            'tmt_keluar'         => ($row[10] != null) ? Carbon::createFromFormat('Y-m-d', $row[10])->format('Y-m-d') : null,
        ]);
    }

    public function uniqueBy()
    {
        return 'nik ';
    }

    public function startRow(): int
    {
        return 2;
    }

    public function batchSize(): int
    {
        return 50;
    }

    public function chunkSize(): int
    {
        return 50;
    }
}
