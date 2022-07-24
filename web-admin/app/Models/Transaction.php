<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'branch_id',
        'user_id',
        'kurir_id',
        'nama',
        'tanggal',
        'total',
        'metode',
        'status',
    ];

    public static function statuses()
    {
        return [
            0 => 'Tunggu',
            1 => 'Proses',
            2 => 'Diantar',
            3 => 'Selesai',
            4 => 'Batal'
        ];
    }

    public static function metode()
    {
        return [
            0 => 'Transfer',
            1 => 'COD',
        ];
    }

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function kurir()
    {
        return $this->belongsTo('App\Models\Kurir');
    }

    public function detail()
    {
        return $this->hasMany('App\Models\DetailTransactions');
    }
}
