<?php

namespace App\Imports\Personalia;

use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
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
use DateTime;

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

        $tmt_masuk        = null;
        $tmt_keluar       = null;
        $tmt_masuk_parse  = null;
        $tmt_keluar_parse = null;
        $final_masuk      = null;
        $final_keluar     = null;
        // dd(Date::excelToDateTimeObject($row['tmt_masuk']));

        // try {
        if ($row['tmt_masuk'] != null) {
            $tmt_masuk = Date::excelToDateTimeObject($row['tmt_masuk']);

            // $date_masuk = new DateTime($tmt_masuk);
            // // Convert the DateTime object to a string using the format() method
            // $final_masuk = $date_masuk->format('Y-m-d H:i:s');

            // $date_keluar = new DateTime($tmt_keluar);
            // // Convert the DateTime object to a string using the format() method
            // $final_keluar = $date_keluar->format('Y-m-d H:i:s');
            // $tmt_masuk_parse  = Carbon::createFromFormat('d/m/Y H:i', $tmt_masuk);
            // $tmt_keluar_parse = Carbon::createFromFormat('d/m/Y H:i', $tmt_keluar);
            $final_masuk = Carbon::parse($tmt_masuk)->format('Y-m-d');
            // dd($final_masuk);
            // $tmt_masuk  = Carbon::createFromFormat('d/m/Y H:i', $row['tmt_masuk']);
            // $tmt_keluar = Carbon::createFromFormat('d/m/Y H:i', $row['tmt_keluar']);
        } else {
            $tmt_masuk = null;
        }
        if ($row['tmt_masuk'] != null) {
            $tmt_keluar   = Date::excelToDateTimeObject($row['tmt_keluar']);
            $final_keluar = Carbon::parse($tmt_keluar)->format('Y-m-d');
        } else {
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
