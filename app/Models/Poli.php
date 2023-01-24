<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poli extends Model
{
    use HasFactory;
    protected $table = 'poli';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id_poli_rs',
        'kode',
        'kode_sms',
        'nama',
        'stat',
    ];

    protected $hidden = [];
}
