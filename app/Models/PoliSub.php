<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoliSub extends Model
{
    use HasFactory;
    protected $table = 'poli_sub';
    protected $primaryKey = 'id';
    protected $fillable = [
        'poli_id',
        'kode',
        'nama',
        'stat',
    ];

    protected $hidden = [];

    public function poli()
    {
        return $this->hasOne('App\Models\Poli', 'id', 'poli_id');
    }
}
