<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Plugin extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'type',
        'name',
        'alias',
        'author',
        'edition',
        'status',
        'description'

    ];

    protected $primaryKey = 'plugin_id';
}
