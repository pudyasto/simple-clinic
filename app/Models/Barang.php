<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = 'barang';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode',
        'nama',

        'barang_jenis_id',
        'barang_kategori_id',
        'satuan',

        'harga_beli',
        'margin_jual',
        'pembulatan',
        'harga_jual',
    ];

    protected $hidden = [];

    public function jenis()
    {
        return $this->hasOne('App\Models\BarangJenis', 'id', 'barang_jenis_id');
    }
    
    public function kategori()
    {
        return $this->hasOne('App\Models\BarangKategori', 'id', 'barang_kategori_id');
    }
}
