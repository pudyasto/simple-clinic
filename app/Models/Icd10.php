<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Icd10 extends Model
{
    use HasFactory;
    protected $table = 'icd10';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id', 
        'lvlhr', 
        'tree_class', 
        'code_who', 
        'terminal_node', 
        'block_icd', 
        'code_icd', 
        'title_icd', 
        'title_id'
    ];

    protected $hidden = [];
}
