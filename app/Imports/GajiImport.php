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

        foreach ($rows as $row) {
            $nlBruto1 = $row['tj_kelu'] + $row['tj_pend'];

            $jmHasil = $nlBruto1 + $row['tj_jbt'] + $row['tj_alih'] + $row['tj_kesja'] + $row['tj_beras'] + $row['tj_rayon'] + $row['tj_makan'] + $row['tj_sostek'] + $row['tj_kes'] + $row['tj_dapen'] + $row['tj_hadir_18'] + $row['tj_bhy'] + $row['thr'] + $row['bonus'] + $row['lembur'] + $row['kurang'];


            Gaji::updateOrCreate(
                ['npp' => $row['npp'], 'tgl_gaji' => $row['tgl_gaji']],
                [
                    'npp'  => $row['npp'],
                    'nama'  => $row['nama'],
                    'st_peg'  => $row['st_peg'],
                    'st_ptkp'  => $row['st_ptkp'],
                    'gapok'  => $row['gapok'],
                    'tj_kelu'  => $row['tj_kelu'],
                    'tj_pend'  => $row['tj_pend'],
                    'nl_bruto1'  => $nlBruto1,
                    'tj_jbt'  => $row['tj_jbt'],
                    'tj_alih'  => $row['tj_alih'],
                    'tj_kesja'  => $row['tj_kesja'],
                    'tj_beras'  => $row['tj_beras'],
                    'tj_rayon'  => $row['tj_rayon'],
                    'tj_makan'  => $row['tj_makan'],
                    'tj_sostek'  => $row['tj_sostek'],
                    'tj_kes'  => $row['tj_kes'],
                    'tj_dapen'  => $row['tj_dapen'],
                    'tj_hadir'  => $row['tj_hadir_18'],
                    'tj_bhy'  => $row['tj_bhy'],
                    'thr'  => $row['thr'],
                    'bonus'  => $row['bonus'],
                    'lembur'  => $row['lembur'],
                    'kurang'  => $row['kurang'],
                    'jm_hasil' => $jmHasil,
                    'tgl_gaji' => $row['tgl_gaji'],
                    'pot_dapen'  => $row['pot_dapen'],
                    'pot_sostek'  => $row['pot_sostek'],
                    'pot_kes'  => $row['pot_kes'],
                    'pot_swk'  => $row['pot_swk'],

                ]
            );
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
