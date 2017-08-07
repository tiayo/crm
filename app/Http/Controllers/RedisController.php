<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function redisMultiDelete($keyword)
    {
        $keys = Redis::keys($keyword.'*');

        foreach ($keys as $key) {
            //删除键值
            Redis::set($key, null);
        }

        return true;
    }
}