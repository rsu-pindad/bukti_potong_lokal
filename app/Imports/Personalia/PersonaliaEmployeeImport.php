<?php

namespace App\Imports\Personalia;

use App\Models\Employee;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class PersonaliaEmployeeImport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements OnEachRow, WithCustomValueBinder, WithHeadingRow, WithChunkReading, WithSkipDuplicates
{
    protected $mulai;
    protected $akhir;

    public function uniqueBy()
    {
        return ['id', 'nik'];
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $tmt_masuk    = null;
        $tmt_keluar   = null;
        $final_masuk  = null;
        $final_keluar = null;

        $nik = Employee::where('nik', $row['nik'])->first();
        if ($nik) {
            if ($row['tmt_masuk'] != null) {
                $tmt_masuk   = $row['tmt_masuk'];
                $final_masuk = Carbon::createFromFormat('d/m/Y', $tmt_masuk)->format('Y-m-d');
            } else {
                $tmt_masuk = null;
            }
            if ($row['tmt_keluar'] != null) {
                $tmt_keluar   = $row['tmt_keluar'];
                $final_keluar = Carbon::createFromFormat('d/m/Y', $tmt_keluar)->format('Y-m-d');
            } else {
                $tmt_keluar = null;
            }

            $nik->npp                = $row['npp'];
            $nik->npp_baru           = $row['npp_baru'];
            $nik->nama               = $row['nama'];
            $nik->status_kepegawaian = $row['status_kepegawaian'];
            $nik->nik                = $row['nik'];
            $nik->npwp               = $row['npwp'];
            $nik->status_ptkp        = $row['status_ptkp'];
            $nik->email              = $row['email'];
            $nik->no_hp              = $row['no_hp'];
            $nik->tmt_masuk          = $final_masuk;
            $nik->tmt_keluar         = $final_keluar;
            $nik->save();

            return false;
        }

        $store = Employee::insert([
            'npp'                => $row['npp'],
            'npp_baru'           => $row['npp_baru'],
            'nama'               => $row['nama'],
            'status_kepegawaian' => $row['status_kepegawaian'],
            'nik'                => $row['nik'],
            'npwp'               => $row['npwp'],
            'status_ptkp'        => $row['status_ptkp'],
            'email'              => $row['email'],
            'no_hp'              => $row['no_hp'],
            'tmt_masuk'          => $final_masuk,
            'tmt_keluar'         => $final_keluar,
            'created_at'         => Carbon::now(),
        ]);

        return $store;
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
