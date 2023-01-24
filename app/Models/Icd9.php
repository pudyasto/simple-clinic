<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icd9 extends Model
{
    use HasFactory;
    protected $table = 'icd9';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code', 
        'short_description', 
        'description',
    ];

    protected $hidden = [];
}
