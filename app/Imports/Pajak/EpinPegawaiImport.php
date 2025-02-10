<?php

namespace App\Imports\Pajak;

use App\Models\Employee;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use PhpOffice\PhpSpreadsheet\Cell\StringValueBinder;

class EpinPegawaiImport extends StringValueBinder implements OnEachRow, WithHeadingRow, WithChunkReading
{
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
