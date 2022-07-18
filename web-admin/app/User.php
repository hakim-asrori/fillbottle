<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'email', 'password', 'level',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getFullNameAttribute()
    {
        if (is_null($this->last_name)) {
            return "{$this->name}";
        }

        return "{$this->name} {$this->last_name}";
    }

    public static function levels()
    {
        return [
            0 => 'Admin',
            1 => 'Cabang',
        ];
    }

    public function branches()
    {
        return $this->belongsToMany('App\Models\Branch', 'user_branches');
    }

    public function kurir()
    {
        return $this->hasOne('App\Models\Kurir');
    }

    public function getAlamatLengkapAttribute()
    {
        return "{$this->kurir->alamat}, {$this->kurir->kota}, {$this->kurir->provinsi}, {$this->kurir->kodepos}";
    }

    public function getLevelNameAttribute()
    {
        switch ($this->level) {
            case '0':
                return "Admin";
                break;
            case '1':
                return "Cabang";
                break;
            case '2':
                return "Kurir";
                break;
            case '3':
                return "Customer";
                break;
            default:
                return "N/A";
                break;
        }
    }
}
