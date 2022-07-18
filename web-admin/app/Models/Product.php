<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['kode','partner_id', 'nama', 'deskripsi', 'harga', 'foto'];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'product_categories');
    }
}
