<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublishFile extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'publish_file';

    protected $fillable = [
        'folder_uniq',
        'folder_path',
        'folder_publish',
        'folder_name',
        'folder_status',
        'folder_jumlah_final',
        'folder_jumlah_tidak_final',
        'folder_jumlah_aone'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function hashPublished(): HasMany
    {
        return $this->hasMany(PublishFileNpwp::class, 'publish_file_id', 'id');
    }

    public function delete()
    {
        $this->hashPublished()->delete();

        return parent::delete();
    }
}
