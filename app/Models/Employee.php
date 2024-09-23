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
}
