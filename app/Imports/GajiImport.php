<?php

namespace App\Imports;

use App\Models\Gaji;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');
class GajiImport implements ToCollection, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */


    public function collection(Collection $rows)
    {
        dd($rows);
        // $dateString = $rows[0]['BULAN,C,254'] . "/01";
        // $strtotime = strtotime($dateString);
        // $bulan = date("Y-m-d", $strtotime);


        // Gaji::where('bulan', $bulan)->delete();

        // foreach ($rows as $row) {
        //     Gaji::create([
        //         'npp'  => $row['NPK,C,254'],
        //         'nama'  => $row['NAMA,C,254'],
        //         'st_peg'  => $row['KD_STPEG,C,254'],
        //         'st_kelu'  => $row['ST_KELU,C,254'],
        //         'st_beras'  => $row['ST_BERAS,C,254'],
        //         'st_ptkp'  => $row['ST_PTKP,C,254'],
        //         'gol_gapok'  => $row['GOL_GAPO,C,254'],
        //         'gapok'  => $row['GAPOK,N,19,5'],
        //         'tj_kelu'  => $row['TJ_KELU,N,19,5'],
        //         'nl_bruto'  => $row['NL_BRUTO1,N,19,5'],
        //         'tj_jbt'  => $row['TJ_JBT,N,19,5'],
        //         'tj_kesja'  => $row['TJ_KESJA,N,19,5'],
        //         'tj_profesi'  => $row['TJ_PROFESI,N,19,5'],
        //         'tj_beras'  => $row['TJ_BERAS,N,19,5'],
        //         'tj_rayon'  => $row['TJ_RAYON,N,19,5'],
        //         'tj_didik'  => $row['TJ_DIDIK,N,19,5'],
        //         'tj_bhy'  => $row['TJ_BHY,N,19,5'],
        //         'tj_hadir'  => $row['TJ_HADIR,N,19,5'],
        //         'tj_alih'  => $row['TJ_ALIH,N,19,5'],
        //         'rapel'  => $row['RAPEL,N,19,5'],
        //         'lembur'  => $row['LEMBUR,N,19,5'],
        //         'kurang'  => $row['KURANG,N,19,5'],
        //         'lebih'  => $row['LEBIH,N,19,5'],
        //         'pt_pph21'  => $row['PT_PPH21,N,19,5'],
        //         'tpp'  => $row['TPP,N,19,5'],
        //         'tpu'  => $row['TPU,N,19,5'],
        //         'cuti'  => $row['CUTI,N,19,5'],
        //         'thr'  => $row['THR,N,19,5'],
        //         'bulan'  =>  $bulan,
        //     ]);
        // }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
