<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliTindakan extends Model
{
    use HasFactory;
    protected $table = 'poli_tindakan';
    protected $primaryKey = 'id';
    protected $fillable = [        
        'registrasi_id',
        'poli_id',
        'pegawai_id',
        'pasien_id',

        'tindakan_id', 
        'icd9', 
        'nama', 
        'tarif', 
    ];

    protected $hidden = [];


    public function tindakan()
    {
        return $this->hasOne('App\Models\Tindakan', 'id', 'tindakan_id');
    }


    public function registrasi()
    {
        return $this->hasOne('App\Models\Registrasi', 'id', 'registrasi_id');
    }
}
