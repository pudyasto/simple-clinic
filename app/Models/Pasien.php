<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;
    protected $table = 'pasien';
    protected $primaryKey = 'id';
    protected $fillable = [
        'no_rm', 
        'nama_pasien', 
        'no_identitas',
        'asuransi_id', // Skip 
        'no_asuransi', // Skip 
        'tmp_lahir', 
        'tgl_lahir', 
        'jenis_kelamin', 
        'agama', 
        'pekerjaan', 
        'gol_darah', 
        'pendidikan',  // Skip 
        'alamat', 
        'prov_id', 
        'kota_id', 
        'kec_id', 
        'kel_id', 
        'no_telp', 
        'email', 
        'alergi', 
        'penyakit', 
        'foto', 
        'user_id',
    ];

    protected $hidden = [];
}
