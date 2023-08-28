<?php

namespace App\Imports;

use App\Models\Gaji;
use Carbon\Carbon;
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
        $tglGaji = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rows[0]['TGL_GAJI']);

        Gaji::where('tgl_gaji', $tglGaji)->delete();


        foreach ($rows as $row) {
            $nlBruto1 = $row['TJ_KELU'] + $row['TJ_PEND'];
            $jmHasil = $nlBruto1 + $row['TJ_JBT'] + $row['TJ_ALIH'] + $row['TJ_KESJA'] + $row['TJ_BERAS'] + $row['TJ_RAYON'] + $row['TJ_MAKAN'] + $row['TJ_SOSTEK'] + $row['TJ_KES'] + $row['TJ_DAPEN'] + $row['TJ_HADIR_18'] + $row['TJ_BHY'] + $row['THR'] + $row['BONUS'] + $row['LEMBUR'] + $row['KURANG'];


            Gaji::create([
                'npp'  => $row['NPP'],
                'nama'  => $row['NAMA'],
                'st_peg'  => $row['ST_PEG'],
                'st_ptkp'  => $row['ST_PTKP'],
                'gapok'  => $row['GAPOK'],
                'tj_kelu'  => $row['TJ_KELU'],
                'tj_pend'  => $row['TJ_PEND'],
                'nl_bruto1'  => $nlBruto1,
                'tj_jbt'  => $row['TJ_JBT'],
                'tj_alih'  => $row['TJ_ALIH'],
                'tj_kesja'  => $row['TJ_KESJA'],
                'tj_beras'  => $row['TJ_BERAS'],
                'tj_rayon'  => $row['TJ_RAYON'],
                'tj_makan'  => $row['TJ_MAKAN'],
                'tj_sostek'  => $row['TJ_SOSTEK'],
                'tj_kes'  => $row['TJ_KES'],
                'tj_dapen'  => $row['TJ_DAPEN'],
                'tj_hadir'  => $row['TJ_HADIR_18'],
                'tj_bhy'  => $row['TJ_BHY'],
                'thr'  => $row['THR'],
                'bonus'  => $row['BONUS'],
                'lembur'  => $row['LEMBUR'],
                'kurang'  => $row['KURANG'],
                'jm_hasil' => $jmHasil,
                'tgl_gaji' => $tglGaji,
                'pot_dapen'  => $row['POT_DAPEN'],
                'pot_sostek'  => $row['POT_SOSTEK'],
                'pot_kes'  => $row['POT_KES'],
                'pot_swk'  => $row['POT_SWK'],

            ]);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
