<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Karyawan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'karyawan';

    protected $fillable = [
        'user_id',
        'npp',
        'nama',
        'email',
        'no_tel',
        'st_ptkp',
        'npwp',
        'st_peg',
        'epin',
        'user_edited'
    ];

    protected $hidden = [
        'user_id',
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    protected $casts = [
        'user_edited' => 'boolean'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
