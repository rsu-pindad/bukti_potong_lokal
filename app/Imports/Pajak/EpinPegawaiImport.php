<?php

namespace App\Imports\Pajak;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Row;

class EpinPegawaiImport implements OnEachRow, WithHeadingRow, WithUpserts, WithChunkReading, WithBatchInserts, SkipsEmptyRows, WithSkipDuplicates
{
    public function uniqueBy()
    {
        return ['id', 'nik'];
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $data = Employee::where('nik', $row['nik'])->first();
        if ($data) {
            if ($row['npwp'] != null) {
                $data->npwp = $row['npwp'];
            }
            $data->epin = $row['epin'];
            $data->save();

            return;
        }

        return false;
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
