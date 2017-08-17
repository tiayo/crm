<?php

namespace App\Services;

interface RedisServiceInterface
{
    /**
     * 批量添加redis键值
     *
     * @param $prefix {KEY前缀}
     * @param $value {value数组，只取第一层， 如果第二层是数组，将进行序列化再存储}
     * @param $expir {存储过期时间}
     * @param $suffix {规则在下面：}
     * $suffix：KEY后缀规则，传�
     * �$value中的一个字段作为后缀。
     * $suffix：默认规则：数组键值作为后缀;
     * $suffix：如果有传值，将在数组中找到对应字段的值作为后缀，如果数组未存在该字段，使用默认规则
     *
     * @return mixed
     */
    public function redisMultiAdd($prefix, $value, $expir = 0, $suffix = null);

    /**
     * 添加单个redis键值
     *
     * @param $keyword {KEY值}
     * @param $value {value值，如果是数组，将进行序列化再存储}
     * @param $expir {存储过期时间}
     *
     * @return mixed
     */
    public function redisSingleAdd($keyword, $value, $expir = 0);

    /**
     * 批量删除redis键值
     *
     * @param $keyword {键值前缀，将删除前缀相同的所有键值}
     *
     * @return bool
     */
    public function redisMultiDelete($prefix);

    /**
     * 删除redis�
     * �体键值
     *
     * @param $keyword {�
     * �体键值}
     *
     * @return mixed
     */
    public function redisSingleDelete($keyword);

    /**
     * 读取单个键值
     *
     * @param $keyword
     *
     * @return mixed
     */
    public function redisSingleGet($keyword);

    /**
     * 读取多个键值
     *
     * @param $prefix
     *
     * @return array
     */
    public function redisMultiGet($prefix);
}
