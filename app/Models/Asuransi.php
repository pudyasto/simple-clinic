<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asuransi extends Model
{
    use HasFactory;
    protected $table = 'asuransi';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kode',
        'nama',
        'stat',
    ];
}
