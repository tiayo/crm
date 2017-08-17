<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Managergroup extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'name',
        'rule',
        'parent_id',
    ];

    protected $primaryKey = 'managergroup_id';
}
