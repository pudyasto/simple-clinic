<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PegawaiJenis extends Model
{
    use HasFactory;
    protected $table = 'jenis_pegawai';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
    ];

    protected $hidden = [];
}
