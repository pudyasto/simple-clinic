<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrasi extends Model
{
    use HasFactory;
    protected $table = 'registrasi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode',
        'kode_booking',
        'tgl_kunjungan',
        'tgl_daftar',
        'pasien_id',

        'poli_id', 
        'asuransi_id', 
        'nomor_asuransi', 
        'pegawai_id', 
        'dokter_urut', 
        
        'keluhan', 
        'pasien_baru', 
        'stat_kunjungan', 
        'keterangan_batal', 
        'tgl_batal', 
        'user_id',
    ];

    protected $hidden = [];


    public function poli()
    {
        return $this->hasOne('App\Models\Poli', 'id', 'poli_id');
    }

    public function pasien()
    {
        return $this->hasOne('App\Models\Pasien', 'id', 'pasien_id');
    }

    public function pegawai()
    {
        return $this->hasOne('App\Models\Pegawai', 'id', 'pegawai_id');
    }
}
