<?php

namespace App\Imports;

use App\Models\Employee;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PegawaiBaruImport implements OnEachRow, WithHeadingRow, WithUpserts, WithChunkReading, WithBatchInserts, SkipsEmptyRows, WithSkipDuplicates
{
    public function uniqueBy()
    {
        return ['id', 'nik'];
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $nik = Employee::where('nik', $row['nik'])->first();
        if ($nik) {
            $nik->npp                = $row['npp_baru'] ?? $row['npp'];
            $nik->npp_baru           = $row['npp_baru'];
            $nik->nama               = $row['nama'];
            $nik->status_kepegawaian = $row['status_kepegawaian'];
            $nik->nik                = $row['nik'];
            $nik->npwp               = $row['npwp'];
            $nik->status_ptkp        = $row['status_ptkp'];
            $nik->email              = $row['email'];
            $nik->no_hp              = $row['no_hp'];
            $nik->tmt_masuk          = $row['tmt_masuk'] == null ? null : Carbon::parse(Date::excelToDateTimeObject($row['tmt_masuk']))->format('d/m/Y');
            $nik->tmt_keluar         = $row['tmt_keluar'] == null ? null : Carbon::parse(Date::excelToDateTimeObject($row['tmt_keluar']))->format('d/m/Y');
            $nik->save();

            return;
        }

        return Employee::insert([
            'npp'                => $row['npp_baru'] ?? $row['npp'],
            'npp_baru'           => $row['npp_baru'],
            'nama'               => $row['nama'],
            'status_kepegawaian' => $row['status_kepegawaian'],
            'nik'                => $row['nik'],
            'npwp'               => $row['npwp'],
            'status_ptkp'        => $row['status_ptkp'],
            'email'              => $row['email'],
            'no_hp'              => $row['no_hp'],
            'tmt_masuk'          => $row['tmt_masuk'] == null ? null : Carbon::parse(Date::excelToDateTimeObject($row['tmt_masuk']))->format('d/m/Y'),
            'tmt_keluar'         => $row['tmt_masuk'] == null ? null : Carbon::parse(Date::excelToDateTimeObject($row['tmt_keluar']))->format('d/m/Y'),
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
