<?php
/**
 * SPG Core Model
 *
 * @author Corrie Zhao
 */

namespace Model\Redis;

/**
 * @property string $create_time  创建时间
 * @property string $modify_time  创建时间
 */
class Core extends \Core\ORM
{

    public static $table = 'default';
    public static $redis;
    public static $keyseed;

    protected $_virtual;

    /**
     * 重构构造
     *
     * @param null $id
     * @param bool $virtual
     */
    public function __construct($id = null, $virtual = false)
    {
        $this->_virtual = $virtual;
        return parent::__construct($id);
    }

    /**
     * 查找一个对象
     *
     * @static
     * @param null $id
     * @return bool|int|Core
     */
    public static function find($id = null)
    {
        if (!$id) return false;

        if ($data = self::cacheGet($id))
        {
            $class = get_called_class();
            return new $class($data);
        }
        return false;
    }

    /**
     * 获取全部
     *
     * @static
     * @return array|bool|int|null|string
     */
    public static function fetch(array $where = NULL, $limit = 0, $offset = 0, array $order_by = NULL)
    {
        $keys = static::redis()->Keys(self::cacheKey('*'));
        $rets = array();
        $model = get_called_class();
        foreach ($keys as $key)
        {
            $rets[$key] = new $model(substr($key, 3));
        }
        return $rets;
    }

    /**
     * 是否存在
     *
     * @static
     * @param $id
     * @return array|bool|int|null|string
     */
    public static function exists($id)
    {
        return static::redis()->Exists(self::cacheKey($id));
    }

    /**
     * 扩展DB加载方式
     *
     * @static
     * @return \Core\Redis
     */
    public static function redis()
    {
        if (!static::$redis)
        {
            static::$redis = \Core\Redis::instance('redis.default');
        }
        return static::$redis;
    }

    public function __set($key, $value)
    {
        if (!isset($this->data[$key]) || $this->data[$key] !== $value)
        {
            $this->data[$key] = $value;
            $this->changed[$key] = $key;
            $this->saved = 0;
        }
    }

    /**
     * 扩展表名获取
     * @static
     * @return string
     */
    public static function cacheKey($id)
    {
        return static::$table . ':' . $id;
    }

    public function getModifyTimeText()
    {
        return $this->modify_time ? date('Y-m-d H:i:s', round($this->modify_time)) : '';
    }

    public function getCreateTimeText()
    {
        return $this->create_time ? date('Y-m-d H:i:s', round($this->create_time)) : '';
    }

    /**
     * 获取缓存Key
     *
     * @return string
     */
    public function getCacheKey()
    {
        return self::cacheKey($this->id);
    }

    /**
     * 加载一个对象
     * @param null $where
     */
    public function load(array $id = NULL)
    {
        if ($this->loaded) return true;

        if (!$data = self::cacheGet($id ? $id : $this->id))
        {
            $this->clear();
            return false;
        }

        foreach ($data as $k=> $v)
        {
            $this->data[$k] = $v;
        }

        return $this->saved = $this->loaded = true;
    }

    /**
     * 保存一个对象
     */
    public function save()
    {
        if (!$this->changed) return $this;

        if (!isset($this->data[static::$key]))
        {
            //插入逻辑
            $this->data['create_time'] = START_TIME;
            $this->data['modify_time'] = START_TIME;
            $this->changed[] = 'modify_time';
            $this->changed[] = 'create_time';
        }
        else
        {
            //更新逻辑
            if (array_key_exists('modify_time', $this->data))
            {
                $this->data['modify_time'] = START_TIME;
                $this->changed[] = 'modify_time';
            }
        }


        if (isset($this->data[static::$key]))
        {
            // 更新
            $data = array();
            foreach ($this->changed as $key)
            {
                $data[$key] = $this->data[$key];
            }
            $this->saved = 1;
        }
        else
        {
            // 新建
            $this->data[static::$key] = md5(static::$keyseed ? $this->data[static::$keyseed] : uniqid());
            $data = $this->data;
            $this->loaded = $this->saved = 1;
        }

        static::redis()->hMSet($this->getCacheKey(), $data);

        $this->changed = array();
        return $this;
    }

    public function delete($id = NULL)
    {
        $cache_key = $id ? self::cacheKey($id) : $this->getCacheKey();

        static::redis()->Del($cache_key);

        // Remove remaining traces
        static::cache_delete(static::cache_key($id));
        $this->clear();

        return true;
    }

    public function related($alias)
    {
        return null;
    }

    public static function cacheGet($id)
    {
        $data = null;
        $cache_key = self::cacheKey($id);
        if (static::redis()->Exists($cache_key))
        {
            $data = static::redis()->hGetAll($cache_key);
        }
        return $data;
    }

    public static function cache_set($key, $value)
    {
        return static::$cache[$key] = $value;
    }

    /**
     * Fetch a value from the cache
     *
     * @param string $key name
     * @return mixed
     */
    public static function cache_get($key)
    {
        return isset(static::$cache[$key]) ? static::$cache[$key] : null;
    }


    /**
     * Delete a value from the cache
     *
     * @param string $key name
     * @return boolean
     */
    public static function cache_delete($key)
    {
        unset(static::$cache[$key]);
        return true;
    }


    /**
     * Check that a value exists in the cache
     *
     * @param string $key name
     * @return boolean
     */
    public static function cache_exists($key)
    {
        return isset(static::$cache[$key]);
    }
}