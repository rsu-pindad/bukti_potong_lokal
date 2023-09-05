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
    protected $pph21;

    public function __construct($month, $year, $pph21)
    {
        $this->month = $month;
        $this->year = $year;
        $this->pph21 = $pph21;
    }


    public function collection()
    {   
        if ($this->pph21 == 0) {
            $pph21 = PPH21::with('gaji.pegawai')->whereRaw("MONTH(tgl_pph21) = $this->month AND YEAR(tgl_pph21) = $this->year AND pph21_sebulan < 1")->get();
        } elseif($this->pph21 == 1) {
            $pph21 = PPH21::with('gaji.pegawai')->whereRaw("MONTH(tgl_pph21) = $this->month AND YEAR(tgl_pph21) = $this->year AND pph21_sebulan > 0")->get();
        } else{
            $pph21 = PPH21::with('gaji.pegawai')->whereRaw("MONTH(tgl_pph21) = $this->month AND YEAR(tgl_pph21) = $this->year")->get();
        }

       return $pph21->map(function ($item) {
            return [
                'masa_pajak' => Carbon::createFromFormat('Y-m-d', $item->tgl_pph21)->format('m'),
                'tahun_pajak' => Carbon::createFromFormat('Y-m-d', $item->tgl_pph21)->format('Y'),
                'pembetulan' => 0,
                'npwp' => $item->gaji->pegawai->npwp ?? 0,
                'nama' => $item->gaji->nama,
                'kode_pajak' => "21-100-01",
                'jumlah_bruto' => $item->bruto,
                'jumlah_pph' => $item->pph21_sebulan,
            ];
        });
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
