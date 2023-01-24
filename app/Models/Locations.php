<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locations extends Model
{
    use HasFactory;
    protected $table = 'locations';
    protected $primaryKey = 'id';
    protected $fillable = [
        'code', 
        'name', 
        'phone', 
        'address', 
        'location_type', 
        'lat_long', 
        'stat', 
        'parent', 
    ];

    protected $hidden = [];
}
