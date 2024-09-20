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
        'nama',
        'nik',
        'npwp',
        'status_ptkp',
        'status_pegawai',
        'email',
        'no_hp',
        'epin'
    ];
}
