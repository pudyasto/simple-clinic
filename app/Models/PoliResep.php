<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliResep extends Model
{
    use HasFactory;
    protected $table = 'poli_resep';
    protected $primaryKey = 'id';
    protected $fillable = [        
        'registrasi_id',
        'poli_id',
        'pegawai_id',
        'pasien_id',

        'barang_id', 
        'qty', 
        'harga_jual', 
    ];

    protected $hidden = [];


    public function barang()
    {
        return $this->hasOne('App\Models\Barang', 'id', 'barang_id');
    }
}
