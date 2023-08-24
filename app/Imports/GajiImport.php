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

        // dd(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($rows[0]['TGL_GAJI']));
        // dd(date("Y-m-d", $rows[0]['TGL_GAJI']));
        Gaji::where('tgl_gaji', $rows[0]['TGL_GAJI'])->delete();

        foreach ($rows as $row) {
            Gaji::create([
                'npp'  => $row['NPP'],
                'nama'  => $row['NAMA'],
                'st_peg'  => $row['ST_PEG'],
                'st_ptkp'  => $row['ST_PTKP'],
                'gapok'  => $row['GAPOK'],
                'tj_kelu'  => $row['TJ_KELU'],
                'tj_pend'  => $row['TJ_PEND'],
                'nl_bruto1'  => $row['NL_BRUTO1'],
                'tj_jbt'  => $row['TJ_JBT'],
                'tj_alih'  => $row['TJ_ALIH'],
                'tj_kesja'  => $row['TJ_KESJA'],
                'tj_beras'  => $row['TJ_BERAS'],
                'tj_rayon'  => $row['TJ_RAYON'],
                'tj_makan'  => $row['TJ_MAKAN'],
                'tj_sostek'  => $row['TJ_SOSTEK'],
                'tj_kes'  => $row['TJ_KES'],
                'tj_dapen'  => $row['TJ_DAPEN'],
                'tj_hadir'  => $row['TJ_HADIR'],
                'tj_bhy'  => $row['TJ_BHY'],
                'lembur'  => $row['LEMBUR'],
                'kurang'  => $row['KURANG'],
                'jm_hasil' => $row['JM_HASIL'],
                'tgl_gaji' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['TGL_GAJI'])

            ]);
        }
    }

    public function headingRow(): int
    {
        return 1;
    }
}
