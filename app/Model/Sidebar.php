<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Sidebar extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'name',
        'route',
        'index',
        'parent',
        'position',
    ];

    protected $primaryKey = 'sidebar_id';
}
