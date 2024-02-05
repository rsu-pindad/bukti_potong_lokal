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

        // dd($pph21);

        // echo '<pre>';
        // $pph21->map(function ($item) {
        //     dd($item);
        // });
        // echo '</pre>';

    //    return $pph21->map(function ($item) {
    //         return [
    //             'masa_pajak' => Carbon::createFromFormat('Y-m-d', $item->tgl_pph21)->format('m'),
    //             'tahun_pajak' => Carbon::createFromFormat('Y-m-d', $item->tgl_pph21)->format('Y'),
    //             'pembetulan' => 0,
    //             'npwp' => $item->gaji->pegawai->npwp ?? 0,
    //             'nama' => $item->gaji->nama,
    //             'kode_pajak' => "21-100-01",
    //             'jumlah_bruto' => $item->bruto,
    //             'jumlah_pph' => $item->pph21_sebulan,
    //         ];
    //     });

    
    return $pph21->map(function ($item) {
         return [
             'masa_pajak' => Carbon::createFromFormat('Y-m-d', $item->tgl_pph21)->format('m'),
             'tahun_pajak' => Carbon::createFromFormat('Y-m-d', $item->tgl_pph21)->format('Y'),
             'pembetulan' => 0,
             'npwp' => $item->gaji->pegawai->npwp ?? 0,
             'nama' => $item->gaji->nama,
             'kode_pajak' => "21-100-01",
             'gapok' => $item->gaji->gapok,
             'tunjangan' => $item->tunjangan, 
             'premi_as' => $item->premi_as, 
             'thr' => $item->gaji->thr, 
             'bonus' => $item->gaji->bonus, 
             'tj_pajak' => $item->tj_pajak, 
             'bruto' => $item->bruto,
             'biaya_jabatan' => $item->biaya_jabatan, 
             'iuran_pensiun' => $item->iuran_pensiun, 
             'pot_sostek' => $item->gaji->pot_sostek,
             'pot_kes' => $item->gaji->pot_kes,
             'pot_swk' => $item->gaji->pot_swk,
             'total_potongan' => $item->total_potongan, 
             'neto_sebulan' => $item->neto_sebulan, 
             'neto_setahun' => $item->neto_setahun, 
             'ptkp' => $item->ptkp, 
             'pkp' => $item->pkp, 
             'pph21_setahun' => $item->pph21_setahun, 
             'pph21_sebulan' => $item->pph21_sebulan, 
         ];
     });

    //  dd($data);
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
            'Gaji Pokok',
            'Tunjangan',
            'Premi AS',
            'THR',
            'Bonus',
            'Tunjangan Pajak',
            'Bruto',
            'Biaya Jabatan',
            'Iuran Pensiun',
            'Potongan Ketenagakerjaan',
            'Potongan Kesehatan',
            'Potongan SWK',
            'Total Potongan',
            'Neto Bulanan',
            'Neto Setahun',
            'PTKP',
            'PKP',
            'PPH21 Setahun',
            'PPH21 Sebulan',
        ];
    }
}
