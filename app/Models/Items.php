<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;
    protected $fillable = [
        'foto',
        'nama',
        'desk',
        'kategori',
        'stok',
        'harga_awal',
        'harga_jual'
    ];
}
