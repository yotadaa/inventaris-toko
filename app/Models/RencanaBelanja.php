<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaBelanja extends Model
{
    use HasFactory;
    protected $fillable = ['group', 'kode', 'qty', 'email', 'created_at'];
}
