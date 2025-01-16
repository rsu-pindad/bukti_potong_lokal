<?php

namespace App\Imports\Personalia;

use App\Models\Employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Row;

class PersonaliaEmployeeImport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements OnEachRow, WithMappedCells, WithCustomValueBinder, WithHeadingRow, WithChunkReading, WithSkipDuplicates, SkipsOnError
{
    use SkipsErrors;

    protected $mulai;
    protected $akhir;

    public function onError(\Throwable $e)
    {
        Log::debug($e->getMessage());
    }

    public function mapping(): array
    {
        return [
            'npp'                => 'A1',
            'npp_baru'           => 'B1',
            'nama'               => 'C1',
            'status_kepegawaian' => 'D1',
            'nik'                => 'E1',
            'npwp'               => 'F1',
            'status_ptkp'        => 'G1',
            'email'              => 'H1',
            'no_hp'              => 'I1',
            'tmt_masuk'          => 'J1',
            'tmt_keluar'         => 'K1',
        ];
    }

    public function uniqueBy()
    {
        return ['id', 'nik'];
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        return Employee::updateOrInsert(
            ['nik' => $row['nik']],
            [
                'npp'                => $row['npp'],
                'npp_baru'           => ($row['npp_baru'] != null) ? $row['npp_baru'] : null,
                'nama'               => $row['nama'],
                'status_kepegawaian' => $row['status_kepegawaian'],
                'npwp'               => ($row['npwp'] != null) ? $row['npwp'] : null,
                'status_ptkp'        => $row['status_ptkp'],
                'email'              => $row['email'],
                'no_hp'              => $row['no_hp'],
                'tmt_masuk'          => ($row['tmt_masuk'] != null) ? Carbon::parse(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $row['tmt_masuk']))->toDateString() : null,
                'tmt_keluar'         => ($row['tmt_keluar'] != null) ? Carbon::parse(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float) $row['tmt_keluar']))->toDateString() : null,
                'created_at'         => Carbon::now(),
            ]
        );
    }

    public function batchSize(): int
    {
        return 1000;
    }

    public function chunkSize(): int
    {
        return 300;
    }
}
