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
            if ($row['tgl_gaji'] == (int)$row['tgl_gaji']) {
                $year = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_gaji'])->format('Y');
                $month = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tgl_gaji'])->format('m');
                $tglGaji = Carbon::createFromDate($year, $month, 25)->format("Y-m-d");
            } else {
                $year = Carbon::createFromFormat('Y-m-d', $row['tgl_gaji'])->format('Y');
                $month = Carbon::createFromFormat('Y-m-d', $row['tgl_gaji'])->format('m');
                $tglGaji = Carbon::createFromDate($year, $month, 25)->format("Y-m-d");
            }

            $nlBruto1 = $row['gapok'] + $row['tj_kelu'] + $row['tj_pend'];

            $jmHasil = $nlBruto1 + $row['tj_jbt'] + $row['tj_alih'] + $row['tj_kesja'] + $row['tj_beras'] + $row['tj_rayon'] + $row['tj_makan'] + $row['tj_sostek'] + $row['tj_kes'] + $row['tj_dapen'] + $row['tj_hadir_18'] + $row['tj_bhy'] + $row['thr'] + $row['bonus'] + $row['lembur'] + $row['kurang'];
            $jmPotongan = $row['pot_dapen'] + $row['pot_sostek'] + $row['pot_kes'] + $row['pot_swk'];


            Gaji::updateOrCreate(
                ['npp' => $row['npp'], 'tgl_gaji' => $tglGaji],
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
                    'tj_kesja'  => $row['tj_kesja'],
                    'tj_makan'  => $row['tj_makan'],
                    'tj_sostek'  => $row['tj_sostek'],
                    'tj_kes'  => $row['tj_kes'],
                    'tj_dapen'  => $row['tj_dapen'],
                    'tj_hadir'  => $row['tj_hadir_18'],
                    'thr'  => $row['thr'],
                    'bonus'  => $row['bonus'],
                    'lembur'  => $row['lembur'],
                    'kurang'  => $row['kurang'],
                    'jm_hasil' => $jmHasil,
                    'tgl_gaji' => $tglGaji,
                    'pot_dapen'  => $row['pot_dapen'],
                    'pot_sostek'  => $row['pot_sostek'],
                    'pot_kes'  => $row['pot_kes'],
                    'pot_swk'  => $row['pot_swk'],
                    'jm_potongan' => $jmPotongan
                ]
            );
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
