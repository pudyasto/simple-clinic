<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasirDetail extends Model
{
    use HasFactory;
    
    protected $table = 'kasir_detail';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kasir_id',
        'jenis_pelayanan',
        'nama',
        
        'harga', 
        'qty', 
        'diskon', 
        'subtotal', 
    ];

    protected $hidden = [];
}
