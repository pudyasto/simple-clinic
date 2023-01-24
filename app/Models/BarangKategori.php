<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKategori extends Model
{
    use HasFactory;
    protected $table = 'barang_kategori';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
    ];

    protected $hidden = [];
}
