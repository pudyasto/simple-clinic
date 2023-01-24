<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliUmum extends Model
{
    use HasFactory;
    protected $table = 'poli_umum';
    protected $primaryKey = 'id';
    protected $fillable = [
        'tgl_periksa',
        
        'registrasi_id',
        'poli_id',
        'pegawai_id',
        'pasien_id',

        'fisik_td',
        'fisik_nadi',
        'fisik_nafas',
        'fisik_suhu',
        'fisik_tb',
        'fisik_bb',
        
        'ringkasan', 

        'diagnosa_utama', 
        'ket_diagnosa_utama', 

        'diagnosa_sekunder_1', 
        'diagnosa_sekunder_2', 
        'ket_diagnosa_sekunder',
    ];

    protected $hidden = [];

    function pasien()
    {
        return $this->hasOne('App\Models\Pasien', 'id', 'pasien_id');
    }

    function diag_utama()
    {
        return $this->hasOne('App\Models\Icd10', 'code_icd', 'diagnosa_utama');
    }

    function diag_sekunder_1()
    {
        return $this->hasOne('App\Models\Icd10', 'code_icd', 'diagnosa_sekunder_1');
    }

    function diag_sekunder_2()
    {
        return $this->hasOne('App\Models\Icd10', 'code_icd', 'diagnosa_sekunder_2');
    }

    function politindakan()
    {
        return $this->hasMany('App\Models\PoliTindakan', 'registrasi_id', 'registrasi_id');
    }

    function poliresep()
    {
        return $this->hasMany('App\Models\PoliResep', 'registrasi_id', 'registrasi_id');
    }

    function polipenunjang()
    {
        return $this->hasMany('App\Models\PoliPenunjang', 'registrasi_id', 'registrasi_id');
    }
}