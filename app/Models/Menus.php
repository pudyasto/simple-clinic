<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    use HasFactory;
    protected $table = 'menus';
    protected $primaryKey = 'id';
    protected $fillable = [
        'menu_order',
        'menu_header',
        'menu_name',
        'description',
        'link',
        'icon',
        'main_id',
        'is_active',
    ];

    protected $hidden = [];

    public function childs()
    {
        return $this->hasMany('App\Models\Menus', 'main_id', 'id');
    }
}
