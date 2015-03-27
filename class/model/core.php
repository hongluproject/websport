<?php
/**
 * SPG Core Model
 *
 * @author Corrie Zhao
 */

namespace Model;
define('PER_PAGE', 10);
/**
 * @property int    $id           ID
 * @property string $create_time  创建时间
 * @property string $modify_time  创建时间
 * @property string $user_id      用户ID
 */
class Core extends \Core\ORM
{
    public static $body_fields = array();
    public static $body_field_name = 'body';

    public $decoded = false;

    /**
     * 查找一个对象
     *
     * @static
     *
     * @param null $id_or_where
     *
     * @return bool|int|Core
     */
    public static function find($id_or_where = null)
    {
        if (!$id_or_where) return false;

        if (is_numeric($id_or_where) || is_string($id_or_where))
        {
            $where = array('id'=> $id_or_where);
        }
        else
        {
            $where = $id_or_where;
        }
        return self::row($where);
    }

    /**
     * 创建
     *
     * @static
     * @param $data
     * @return \Model\Core
     */
    public static function create($data)
    {
        $called_class = get_called_class();
        $model = new $called_class();
        $model->set($data);
        $model->save();
        return $model;
    }

    /**
     * 通过QUERY获取分页
     *
     * @static
     * @param array|null $where
     * @param int        $num
     * @param array|null $order_by
     * @return object
     */
    public static function fetchAsPageByQuery(array $where = NULL, $num = 10, array $order_by = null)
    {
        $page = (int)$_GET['page'];
        if ($page < 1) $page = 1;
        $query = $_GET;
        unset($query['page']);
        if (!empty($query))
        {
            foreach ($query as $k => $v)
            {
                $query[$k] = urlencode($k) . "=" . urlencode($v);
            }
            $path = PATH . '?' . join('&', $query) . '&page=:page';
        }
        else
        {
            $path = PATH . '?' . 'page=:page';
        }
        return static::fetchAsPage($where, $page, $num, $order_by, $path);
    }



    /**
     * 通过QUERY获取分页
     *
     * @static
     * @param array|null $where
     * @param int        $num
     * @param array|null $order_by
     * @return object
     */
    public static function fetchAsPageByAvos($num = 10,$total)
    {
        $page = (int)$_GET['page'];
        if ($page < 1) $page = 1;
        $query = $_GET;
        unset($query['page']);
        if (!empty($query))
        {
            foreach ($query as $k => $v)
            {
                $query[$k] = urlencode($k) . "=" . urlencode($v);
            }
            $path = PATH . '?' . join('&', $query) . '&page=:page';
        }
        else
        {
            $path = PATH . '?' . 'page=:page';
        }
         $page = new \Core\Pagination($total, $page, $num, $path);
        return (object)array(
            'list'  => 'null',
            'total' => $total,
            'page'  => $page,
        );
    }

    /**
     * 按照分页返回
     *
     * @static
     * @param array|null $where
     * @param int        $page
     * @param int        $num
     * @param array|null $order_by
     * @param null       $path
     * @return object
     */
    public static function fetchAsPage(array $where = NULL, $page = 1, $num = 10, array $order_by = null, $path = null)
    {
        $data = static::fetchByPage($where, $page, $num, $order_by);
        $total = static::count($where);
        $page = new \Core\Pagination($total, $page, $num, $path);
        return (object)array(
            'list'  => $data,
            'total' => $total,
            'page'  => $page,
        );
    }

    /**
     * 按照页获取
     *
     * @static
     * @param array|null $where
     * @param int        $page
     * @param int        $num
     * @param array|null $order_by
     * @return array
     */
    public static function fetchByPage(array $where = NULL, $page = 1, $num = 10, array $order_by = null)
    {
        if ($page <= 1) $page = 1;
        $limit = $num;
        $offset = $limit * ($page - 1);
        return parent::fetch($where, $limit, $offset, $order_by);
    }

    /**
     * 扩展DB加载方式
     *
     * @static
     * @return \Core\Database
     */
    public static function db()
    {
        if (!static::$db)
        {
            static::$db = new \Core\Database(config('database.default'));
        }
        return parent::db();
    }

    /**
     * 扩展表名获取
     *
     * @static
     * @return string
     */
    public static function table()
    {
        return  static::$table;
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
            $this->data['create_time'] = START_DATETIME;
            $this->changed[] = 'create_time';

            if (isset($this->data['modify_time'])) {
                $this->data['modify_time'] = START_DATETIME;
                $this->changed[] = 'modify_time';
            }
            if (isset($this->data['user_id'])) {
                $this->data['user_id'] = $_SESSION['user_id'];
                $this->changed[] = 'user_id';
            }
        }
        else
        {
            //更新逻辑
            if (array_key_exists('modify_time', $this->data))
            {
                $this->data['modify_time'] = START_DATETIME;
                $this->changed[] = 'modify_time';
            }
        }

        $this->_encodeBody();
        $saved = parent::save();
        $this->_decodeBody();
        return $saved;
    }

    /**
     * 解码自由结构成模型结构
     */
    private function _decodeBody()
    {
        if ($this->decoded) return;

        if (!empty(static::$body_fields) && static::$body_field_name)
        {
            $body = json_decode($this->data[static::$body_field_name], true);
            foreach (static::$body_fields as $field)
            {
                $this->data[$field] = isset($body[$field]) ? $body[$field] : null;
                unset($this->data[static::$body_field_name]);
            }
        }
        $this->decoded = true;
    }

    /**
     * 转码自由结构成数据库结构
     */
    private function _encodeBody()
    {
        if (!$this->decoded) return;

        if (!empty(static::$body_fields) && static::$body_field_name)
        {
            $body = array();
            foreach (static::$body_fields as $field)
            {
                if (!is_null($this->data[$field])) $body[$field] = $this->data[$field];
                if (isset($this->changed[$field]))
                {
                    unset($this->changed[$field]);
                    if (!isset($this->changed['body'])) $this->changed['body'] = 'body';
                }
                unset($this->data[$field]);
            }
            $this->data[static::$body_field_name] = json_encode($body);
        }

        $this->decoded = false;
    }

    public function getDisplayModifyTime()
    {
        return $this->modify_time;
    }

    public function getDisplayCreateTime()
    {
        return $this->create_time;
    }

    public function formateTime( $time )
    {
        return date('Y-m-d H:i:s',$time);
    }

    public function __set($key, $value)
    {
        if (in_array($key, static::$body_fields)) $this->load();
        parent::__set($key, $value);
    }


    public function __get($key)
    {
        if (in_array($key, static::$body_fields)) $this->load();
        return parent::__get($key);
    }

    public function __isset($key)
    {
        if (in_array($key, static::$body_fields)) $this->load();
        return parent::__isset($key);
    }

    public function __unset($key)
    {
        if (in_array($key, static::$body_fields)) $this->load();
        parent::__unset($key);
    }

    public static function cache_set($key, $value)
    {
        return static::$cache[$key] = $value;
    }


    /**
     * Fetch a value from the cache
     *
     * @param string $key name
     *
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
     *
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
     *
     * @return boolean
     */
    public static function cache_exists($key)
    {
        return isset(static::$cache[$key]);
    }

    /**
     * 删除一条记录
     *
     * @static
     * @param $id
     * @return int|boolean
     */
    public static function remove($id)
    {
        $model = self::find($id);
        if ($model)
        {
            return $model->delete();
        }
        return false;
    }
}