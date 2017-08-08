<?php

namespace Plugins\User\TestUser\Model;

use Illuminate\Database\Eloquent\Model;

class TestUser extends Model
{
    public $timestamps = true;

    protected $fillable = [

    ];

    protected $primaryKey = 'testuser_id';
}
