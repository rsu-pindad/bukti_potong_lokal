<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'tbl_gaji';
    protected $guarded = ['id'];

    public function pph21(): HasOne
    {
        return $this->hasOne(PPH21::class, 'id_gaji');
    }
}
