<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;
    protected $table = 'pegawai';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode',
        'nama',
        'alamat',
        'telp',
        'foto',
        'jenis_pegawai_id',
        'poli_id',
        'poli_sub_id',
        'cabang_id',
    ];

    protected $hidden = [];

    function pegawaijenis()
    {
        return $this->hasOne('App\Models\PegawaiJenis', 'id', 'jenis_pegawai_id');
    }
}
