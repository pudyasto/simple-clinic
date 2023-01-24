<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangJenis extends Model
{
    use HasFactory;
    protected $table = 'barang_jenis';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
    ];

    protected $hidden = [];
}
