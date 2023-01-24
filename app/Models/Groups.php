<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    use HasFactory;
    // use Notifiable, SoftDeletes;
    //
    protected $table = 'groups';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [];
}
