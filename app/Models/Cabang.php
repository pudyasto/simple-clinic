<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;
    protected $table = 'cabang';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode',
        'nama',
        'alamat',

        'prov_id',
        'kota_id',
        'kec_id',
        'kel_id',

        'no_telp',
        'email',
        'jenis_cabang',

        'main_id',
    ];
}
