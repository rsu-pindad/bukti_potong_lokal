<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'tbl_pegawai';

    protected $guarded = ['id'];

    public function gajis(): HasMany
    {
        return $this->hasMany(Gaji::class, 'npp');
    }
}
