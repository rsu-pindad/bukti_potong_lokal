<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'is_taken',
        'user_id',
        'is_setuju',
        'tmt_masuk',
        'tmt_keluar',
    ];

    protected $casts = [
        'is_taken' => 'boolean',
        'is_setuju' => 'boolean'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // protected static function boot()
    // {
    //     parent::boot();
    //     self::updated(function (Employee $model) {
    //         $karyawan = Karyawan::where('nik', $model->nik)->first();
    //         if ($karyawan) {
    //             $karyawan->npp     = $model->npp;
    //             $karyawan->nik     = $model->nik;
    //             $karyawan->npwp    = $model->npwp;
    //             $karyawan->email   = $model->email;
    //             $karyawan->no_tel  = $model->no_hp;
    //             $karyawan->st_ptkp = $model->status_ptkp;
    //             $karyawan->st_peg  = $model->status_kepegawaian;
    //             $karyawan->epin    = $model->epin;
    //             $karyawan->save();
    //         }
    //     });
    // }
}
