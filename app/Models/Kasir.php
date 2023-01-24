<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kasir extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'kasir';
    protected $primaryKey = 'id';
    protected $fillable = [
        'registrasi_id',
        'tgl_bayar',
        'kode',
        
        'pasien_id',
        'poli_id', 
        'asuransi_id', 
        'nomor_asuransi', 
        'pegawai_id', 
        
        'subtotal', 
        'diskon', 
        'bayar', 
        'kembali', 
        
        'user_id',
    ];

    protected $hidden = [];


    public function detail()
    {
        return $this->hasMany('App\Models\KasirDetail', 'kasir_id', 'id');
    }


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
