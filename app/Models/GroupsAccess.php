<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class GroupsAccess extends Model
{
    use HasFactory;
    use Notifiable;
    protected $table = 'groups_access';
    protected $primaryKey = ['group_id', 'menu_id'];
    protected $fillable = [
        'group_id',
        'menu_id',
        'privilege',
    ];

    protected $hidden = [];
}
