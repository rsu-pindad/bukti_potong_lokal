<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PPH21 extends Model
{
    use HasFactory;

    protected $table = 'tbl_pph21';

    protected $guarded = ['id'];

    public function gaji(): BelongsTo
    {
        return $this->belongsTo(Gaji::class, 'id_gaji');
    }

    public function pegawai(): BelongsTo
    {
        return $this->belongsTo(Pegawai::class, 'npp', 'npp');
    }
}
