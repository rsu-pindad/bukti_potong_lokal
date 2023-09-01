<?php

namespace App\Exports;

use App\Models\Gaji;
use App\Models\Pegawai;
use App\Models\PPH21;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PPH21Export implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }


    public function collection()
    {
        $pph21 = PPH21::with('gaji.pegawai')->whereRaw("MONTH(tgl_pph21) = $this->month AND YEAR(tgl_pph21) = $this->year")->get();
        $filter = $pph21->map(function ($item) {
            return [
                'masa_pajak' => Carbon::createFromFormat('Y-m-d', $item->tgl_pph21)->format('m'),
                'tahun_pajak' => Carbon::createFromFormat('Y-m-d', $item->tgl_pph21)->format('Y'),
                'pembetulan' => 0,
                'npwp' => $item->gaji->pegawai->npwp,
                'nama' => $item->gaji->pegawai->nama,
                'kode_pajak' => "21-100-01",
                'jumlah_bruto' => $item->bruto,
                'jumlah_pph' => $item->pph21_sebulan,
            ];
        });

        return $filter;
    }

    public function headings(): array
    {
        return [
            'Masa Pajak',
            'Tahun',
            'Pembetulan',
            'NPWP',
            'Nama',
            'Kode Pajak',
            'Jumlah Bruto',
            'Jumlah PPH',
        ];
    }
}
