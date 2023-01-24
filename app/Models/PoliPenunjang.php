<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliPenunjang extends Model
{
    use HasFactory;
    protected $table = 'poli_penunjang';
    protected $primaryKey = 'id';
    protected $fillable = [        
        'registrasi_id',
        'poli_id',
        'pegawai_id',
        'pasien_id',

        'nama_file', 
    ];

    protected $hidden = [];
}
