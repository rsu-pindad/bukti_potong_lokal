<?php

namespace App\Exports;

use App\Models\Gaji;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GajiExport implements FromCollection, WithHeadings
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
        $gaji = Gaji::whereRaw("MONTH(tgl_gaji) = $this->month AND YEAR(tgl_gaji) = $this->year")->get();

        return $gaji->map(function ($item) {
            return [
                'tgl_gaji' => $item->tgl_gaji,
                'npp' => $item->npp,
                'nama' => $item->nama,
                'st_peg' => $item->st_peg,
                'st_ptkp' => $item->st_ptkp,
                'gapok' => $item->gapok,
                'tj_kelu' => $item->tj_kelu,
                'tj_pend' => $item->tj_pend,
                'tj_jbt' => $item->tj_jbt,
                'tj_alih' => $item->tj_alih,
                'tj_kesja' => $item->tj_kesja,
                'tj_beras' => $item->tj_beras,
                'tj_rayon' => $item->tj_rayon,
                'tj_makan' => $item->tj_makan,
                'tj_sostek' => $item->tj_sostek,
                'tj_kes' => $item->tj_kes,
                'tj_dapen' => $item->tj_dapen,
                'tj_hadir' => $item->tj_hadir,
                'tj_bhy' => $item->tj_bhy,
                'thr' => $item->thr,
                'bonus' => $item->bonus,
                'lembur' => $item->lembur,
                'kurang' => $item->kurang,
                'pot_dapen' => $item->pot_dapen,
                'pot_sostek' => $item->pot_sostek,
                'pot_kes' => $item->pot_kes,
                'pot_swk' => $item->pot_swk
            ];
        });
    }

    public function headings(): array
    {
        return [
            'tgl_gaji',
            'npp',
            'nama',
            'st_peg',
            'st_ptkp',
            'gapok',
            'tj_kelu',
            'tj_pend',
            'tj_jbt',
            'tj_alih',
            'tj_kesja',
            'tj_beras',
            'tj_rayon',
            'tj_makan',
            'tj_sostek',
            'tj_kes',
            'tj_dapen',
            'tj_hadir_18',
            'tj_bhy',
            'thr',
            'bonus',
            'lembur',
            'kurang',
            'pot_dapen',
            'pot_sostek',
            'pot_kes',
            'pot_swk',
        ];
    }
}
