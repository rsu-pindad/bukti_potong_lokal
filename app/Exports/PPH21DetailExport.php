<?php

namespace App\Exports;

use App\Models\PPH21;
use App\Models\Gaji;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
// use DB;
use Illuminate\Support\Facades\DB;

class PPH21DetailExport implements FromQuery, WithHeadings
{
    use Exportable;

    protected $pph21;

    public function __construct($pph21)
    {
        $this->pph21 = $pph21;
    }

    public function query()
    {
        $pph21 = PPH21::select(
            'tbl_gaji.npp',
            'tbl_gaji.nama',
            'tbl_gaji.gapok',
            'tbl_pph21.tunjangan', 
            'tbl_pph21.premi_as', 
            'tbl_gaji.thr', 
            'tbl_gaji.bonus', 
            'tbl_pph21.tj_pajak', 
            'tbl_pph21.bruto', 
            'tbl_pph21.biaya_jabatan', 
            'tbl_pph21.iuran_pensiun', 
            'tbl_gaji.pot_sostek',
            'tbl_gaji.pot_kes',
            'tbl_gaji.pot_swk',
            'tbl_pph21.total_potongan', 
            'tbl_pph21.neto_sebulan', 
            'tbl_pph21.neto_setahun', 
            'tbl_pph21.ptkp', 
            'tbl_pph21.pkp', 
            'tbl_pph21.pph21_setahun', 
            'tbl_pph21.pph21_sebulan', 
        )
        ->join('tbl_gaji' ,'tbl_gaji.id', '=' ,'tbl_pph21.id_gaji')
        ->where('tbl_pph21.id','=',$this->pph21);
        // ->get();


        return $pph21;
        // dd($pph21);

        // return PPH21::where('id', $this->pph21);
        // $pph21 = PPH21::where('id', $this->pph21)->get();
        // $data = [];
        // foreach ($pph21 as $p) {
        //     $id_gaji = $p->id_gaji;
        // }
        // $results = [];
        // $result['data'] = $pph21;
        // $data1 = Gaji::where('id',$data['id_gaji'])->get();
        // $result['data'] = $data1;

        // $res = PPH21::join('tbl_gaji', 'tbl_gaji.id', '=', 'tbl_pph21.id_gaji')
        //     ->where('tbl_pph21.id', $this->pph21)
        //     ->get([
        //         'tbl_gaji.npp',
        //         'tbl_gaji.nama',
        //         'tbl_gaji.gapok',
        //         'tbl_pph21.tunjangan', 
        //         'tbl_pph2x1.premi_as', 
        //         'tbl_gaji.thr', 
        //         'tbl_gaji.bonus', 
        //         'tbl_pph21.tj_pajak', 
        //         'tbl_pph21.bruto', 
        //         'tbl_pph21.biaya_jabatan', 
        //         'tbl_pph21.iuran_pensiun', 
        //         'tbl_gaji.pot_sostek',
        //         'tbl_gaji.pot_kes',
        //         'tbl_gaji.pot_swk',
        //         'tbl_pph21.total_potongan', 
        //         'tbl_pph21.neto_sebulan', 
        //         'tbl_pph21.neto_setahun', 
        //         'tbl_pph21.ptkp', 
        //         'tbl_pph21.pkp', 
        //         'tbl_pph21.pph21_setahun', 
        //         'tbl_pph21.pph21_sebulan', 
        //     ]);

    }

    public function headings(): array
    {
        return [
            'nip',
            'nama',
            'gaji_pokok',
            'tunjangan',
            'premi_as',
            'thr',
            'bonus',
            'tunjangan_pajak',
            'bruto',
            'biaya_jabatan',
            'ieuran_pensiun',
            'potongan_ketenakerjaan',
            'potongan_kesehatan',
            'potongan_swk',
            'total_potongan',
            'neto_sebulan',
            'neto_setahun',
            'ptkp',
            'pkp',
            'pph21_setahun',
            'pph21_sebulan',
        ];
    }
}