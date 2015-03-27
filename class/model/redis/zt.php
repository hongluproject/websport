<?php

namespace Model\Redis;

/**
 * @property int $lock        是否锁定
 * @property string $html     内容
 * @property string $url      链接地址
 */
class Zt extends Core
{
    public static $table = 'match';
    public static $keyseed = 'url';

    public function getExpiresText()
    {
        if (!$this->lock)
        {
            return date('Y-m-d H:i:s', $this->expires);
        }
        else
        {
            return '不再更新';
        }
    }
}