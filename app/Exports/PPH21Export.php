<?php

namespace App\Exports;

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
        $pph21 = PPH21::whereRaw("MONTH(tgl_gaji) = $this->month AND YEAR(tgl_gaji) = $this->year")->get();
        $filter = $pph21->map(function ($item) {
            return [
                'masa_pajak' => Carbon::createFromFormat('Y-m-d', $item->tgl_gaji)->format('m'),
                'tahun_pajak' => Carbon::createFromFormat('Y-m-d', $item->tgl_gaji)->format('Y'),
                'pembetulan' => 0,
                'npwp' => $item->pegawai->npwp ?? 0,
                'nama' => $item->nama,
                'kode_pajak' => 0,
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
