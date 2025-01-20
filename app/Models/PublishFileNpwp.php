<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;

class PublishFileNpwp extends Model
{
    use HasFactory;

    protected $table = 'publish_file_npwp';

    protected $fillable = [
        'publish_file_id',
        'file_path',
        'file_name',
        'file_identitas_npwp',
        'file_identitas_nik',
        'file_identitas_nama',
        'file_identitas_alamat',
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function parentPublish(): BelongsTo
    {
        return $this->belongsTo(PublishFile::class, 'publish_file_id', 'id');
    }
}
