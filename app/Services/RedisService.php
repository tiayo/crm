<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class RedisService implements RedisServiceInterface
{
    /**
     * 批量添加.
     *
     * @param $prefix
     * @param $value
     * @param int  $expir
     * @param null $suffix
     *
     * @return bool
     */
    public function redisMultiAdd($prefix, $value, $expir = 0, $suffix = null)
    {
        if (!is_array($value) && !is_object($value)) {
            return false;
        }

        foreach ($value as $key => $item) {
            //默认keyword
            $keyword = $prefix.':'.$key;

            //如果有传入规则
            if (isset($item[$suffix])) {
                if (!is_array($item[$suffix]) && !is_object($item[$suffix]) && (!empty($item[$suffix]) || $item[$suffix] == 0)) {
                    $keyword = $prefix.':'.$item[$suffix];
                }
            }

            //调用单个插入方法
            $this->redisSingleAdd($keyword, $item, $expir);
        }

        return true;
    }

    /**
     * 单个添加.
     *
     * @param $keyword
     * @param $value
     * @param int $expir
     *
     * @return mixed
     */
    public function redisSingleAdd($keyword, $value, $expir = 0)
    {
        if (is_array($value) || is_object($value)) {
            $value = serialize($value);
        }

        if ($expir > 0) {
            return Redis::setex($keyword, $expir, $value);
        }

        return Redis::set($keyword, $value);
    }

    /**
     * 批量删除.
     *
     * @param $prefix
     *
     * @return bool
     */
    public function redisMultiDelete($prefix)
    {
        $keys = Redis::keys($prefix.':*');

        foreach ($keys as $key) {
            //删除键值
            Redis::del($key);
        }

        return true;
    }

    /**
     * 单个删除.
     *
     * @param $keyword
     *
     * @return mixed
     */
    public function redisSingleDelete($keyword)
    {
        return Redis::del($keyword);
    }

    /**
     * 获取单个.
     *
     * @param $keyword
     *
     * @return mixed
     */
    public function redisSingleGet($keyword)
    {
        return Redis::get($keyword);
    }

    /**
     * 批量获取.
     *
     * @param $prefix
     *
     * @return array
     */
    public function redisMultiGet($prefix)
    {
        $array = [];
        $keys = Redis::keys($prefix.':*');

        foreach ($keys as $key) {
            $array[] = $this->redisSingleGet($key);
        }

        return $array;
    }
}
