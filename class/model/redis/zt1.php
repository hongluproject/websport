<?php

namespace Model\Redis;

class Zt1 extends Zt
{
    public static $table = 'match';
    public static $fields = array('url', 'id', 'lock', 'modify_time', 'create_time', 'expires');

    public static function find($id = null)
    {
        if (!$id) return false;

        $cache_key = static::cacheKey($id);
        if ($data = static::redis()->hMGet($cache_key, static::$fields))
        {
            $data = array_combine(static::$fields, $data);
            $class = get_called_class();
            return new $class($data);
        }
        return false;
    }
}