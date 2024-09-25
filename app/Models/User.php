<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'tbl_user';

    protected $guarded = ['id'];

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function karyawan(): HasOne
    {
        return $this->hasOne(Karyawan::class, 'user_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        self::created(function ($model) {
            $karyawan          = new Karyawan;
            $karyawan->nama    = session()->pull('nama', null);
            $karyawan->npp     = session()->pull('npp', null);
            $karyawan->nik     = session()->pull('nik', null);
            $karyawan->npwp    = session()->pull('npwp', null);
            $karyawan->email   = session()->pull('email', null);
            $karyawan->no_tel  = session()->pull('no_hp', null);
            $karyawan->st_ptkp = session()->pull('status_ptkp', null);
            $karyawan->st_peg  = session()->pull('status_kepegawaian', null);
            $karyawan->epin  = session()->pull('epin', null);
            $model->karyawan()->save($karyawan);
            $model->syncRoles('employee');
        });
    }
}
