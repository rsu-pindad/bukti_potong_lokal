<?php

namespace App\Imports\Personalia;

use App\Models\Employee;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithSkipDuplicates;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithUpserts;
use Maatwebsite\Excel\Row;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Shared\StringHelper;

class PegawaiBaruImport extends \PhpOffice\PhpSpreadsheet\Cell\StringValueBinder implements OnEachRow, WithCustomValueBinder, WithHeadingRow, WithChunkReading, WithSkipDuplicates
{
    protected $mulai;
    protected $akhir;

    // public function __construct($mulai, $akhir)
    // {
    //     $this->mulai = $mulai;
    //     $this->akhir = $akhir;
    // }

    // public function startRow(): int
    // {
    //     return $this->mulai;
    // }

    // public function limit(): int
    // {
    //     return $this->akhir;
    // }

    public function uniqueBy()
    {
        return ['id', 'nik'];
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row      = $row->toArray();

        $tmt_masuk  = null;
        $tmt_keluar = null;

        // try {
        if ($row['tmt_masuk'] != null) {
            $tmt_masuk  = Carbon::createFromFormat('d/m/Y', $row['tmt_masuk'])->toDateTimeString;
            $tmt_keluar = Carbon::createFromFormat('d/m/Y', $row['tmt_keluar'])->toDateTimeString;
        } else {
            $tmt_masuk  = null;
            $tmt_keluar = null;
        }
        $nik = Employee::where('nik', $row['nik'])->first();
        if ($nik) {
            $nik->npp                = $row['npp'];
            $nik->npp_baru           = $row['npp_baru'];
            $nik->nama               = $row['nama'];
            $nik->status_kepegawaian = $row['status_kepegawaian'];
            $nik->nik                = $row['nik'];
            $nik->npwp               = $row['npwp'];
            $nik->status_ptkp        = $row['status_ptkp'];
            $nik->email              = $row['email'];
            $nik->no_hp              = $row['no_hp'];
            $nik->tmt_masuk          = $row['tmt_masuk'] == null ? null : Carbon::parse($tmt_masuk)->format('Y-m-d');
            $nik->tmt_keluar         = $row['tmt_keluar'] == null ? null : Carbon::parse($tmt_keluar)->format('Y-m-d');
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
            'tmt_masuk'          => $row['tmt_masuk'] == null ? null : Carbon::parse($tmt_masuk)->format('Y-m-d'),
            'tmt_keluar'         => $row['tmt_keluar'] == null ? null : Carbon::parse($tmt_keluar)->format('Y-m-d'),
            'created_at'         => Carbon::now(),
        ]);

        Log::debug($store);

        return $store;
        // } catch (\Throwable $th) {
        //     Log::error($th->getMessage());
        // }
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
