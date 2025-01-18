<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'employees';

    protected $fillable = [
        'npp',
        'npp_baru',
        'nama',
        'status_kepegawaian',
        'nik',
        'npwp',
        'status_ptkp',
        'email',
        'no_hp',
        'epin',
        'tmt_masuk',
        'tmt_keluar',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected static function boot()
    {
        parent::boot();
        self::updated(function (Employee $model) {
            $karyawan = Karyawan::where('nik', $model->nik)->first();
            if ($karyawan) {
                $karyawan->npp     = $model->npp;
                $karyawan->nik     = $model->nik;
                $karyawan->npwp    = $model->npwp;
                $karyawan->email   = $model->email;
                $karyawan->no_tel  = $model->no_hp;
                $karyawan->st_ptkp = $model->status_ptkp;
                $karyawan->st_peg  = $model->status_kepegawaian;
                $karyawan->epin    = $model->epin;
                $karyawan->save();
            }
        });
    }
}
