<?php

namespace App\Imports\Personalia;

use App\Models\Employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use DateTime;

class PersonaliaEmployeeImport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements OnEachRow, WithMappedCells, WithCustomValueBinder, WithHeadingRow, WithChunkReading, WithSkipDuplicates
{
    protected $mulai;
    protected $akhir;

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
        // dd($row);

        // $tmt_masuk    = null;
        // $tmt_keluar   = null;
        $final_masuk  = null;
        $final_keluar = null;

        // if ($row['tmt_masuk'] != null) {
        //     $masuk     = date_create(strtotime($row['tmt_masuk']));
        //     $tmt_masuk = date_format($masuk, 'Y-m-d');
        //     // $tmt_masuk = date('d/m/Y', $row['tmt_masuk']);
        //     // $tmt_masuk   = Date::excelToTimestamp(strtotime($row['tmt_masuk']));
        //     $final_masuk = Carbon::parse($tmt_masuk)->format('Y-m-d');
        //     dd($final_masuk);
        // } else {
        //     $tmt_masuk   = null;
        //     $final_masuk = null;
        // }
        // if ($row['tmt_keluar'] != null) {
        //     $keluar     = new DateTime(strtotime($row['tmt_keluar']));
        //     $tmt_keluar = $keluar->format('Y-m-d');
        //     // $tmt_keluar = date('d/m/Y', $row['tmt_keluar']);
        //     // $tmt_keluar   = Date::excelToTimestamp(strtotime($row['tmt_keluar']));
        //     $final_keluar = Carbon::parse($tmt_keluar)->format('Y-m-d');
        // } else {
        //     $tmt_keluar   = null;
        //     $final_keluar = null;
        // }
        // dd($row['tmt_masuk']);
        // $tmt_masuk  = null;
        // $tmt_keluar = null;
        // if ($row['tmt_masuk'] instanceof \DateTime) {
        //     $tmt_masuk = Carbon::createFromFormat('Y-m-d', $row['tmt_masuk'])->format('Y-m-d');
        // }
        // if ($row['tmt_keluar'] instanceof \DateTime) {
        //     $tmt_keluar = Carbon::createFromFormat('Y-m-d', $row['tmt_keluar'])->format('Y-m-d');
        // }

        return Employee::updateOrInsert(
            ['nik' => $row['nik']],
            [
                'npp'                => $row['npp'],
                'npp_baru'           => $row['npp_baru'],
                'nama'               => $row['nama'],
                'status_kepegawaian' => $row['status_kepegawaian'],
                'npwp'               => $row['npwp'],
                'status_ptkp'        => $row['status_ptkp'],
                'email'              => $row['email'],
                'no_hp'              => $row['no_hp'],
                'tmt_masuk'          => ($row['tmt_masuk'] == null) ? Carbon::createFromFormat('Y-m-d', $row['tmt_masuk'])->format('Y-m-d') : false,
                'tmt_keluar'         => ($row['tmt_keluar'] == null) ? Carbon::createFromFormat('Y-m-d', $row['tmt_keluar'])->format('Y-m-d') : false,
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
