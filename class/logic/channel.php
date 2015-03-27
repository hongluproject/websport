<?php

namespace Logic;

class Channel
{

    /**
     * 批量获取
     * @static
     * @param $data
     * @return \Model\Redis\Option
     */
    public static function fetch()
    {
        return \Model\Channel::fetch();
    }

    /**
     * 分页批量获取
     * @static
     * @param $data
     * @return \Model\Redis\Option
     */
    public static function fetchAsPageByQuery(array $where = NULL, $num = 1, array $order_by = null, $path = null)
    {
        return \Model\Channel::fetchAsPageByQuery( $where, $num, $order_by, $path);
    }

    /**
     * 分页批量获取
     * @static
     * @param $data
     * @return \Model\Redis\Option
     */
    public static function fetchAsPage(array $where = NULL, $page = 1, $num = 10, array $order_by = null, $path = null)
    {
        return \Model\Channel::fetchAsPage( $where, $page, $num, $order_by, $path);
    }

    /**
     * 创建用户
     *
     * @static
     * @param $data
     * @return \Model\Horn
     */
    public static function create($data)
    {
        $option = new \Model\Channel();
        $option->set($data);
        $option->save();
        return $option;
    }

    /**
     * 更新用户
     * @static
     * @param $id
     * @param $data
     * @return bool|int|\Model\Core
     */
    public static function update($id, $data)
    {
        $option = self::find($id);
        if ($option)
        {
            $option->set($data);
        }
        $option->save();
        return $option;
    }

    /**
     * 删除用户
     *
     * @static
     * @param $id
     * @return int
     */
    public static function delete($id)
    {
        $option = self::find($id);
        return $option->delete();
    }

    /**
     * @static
     * @param $id
     * @return bool|int|\Model\Option
     * @throws \Exception
     */
    public static function find($id)
    {
        if (!$option = \Model\Channel::find($id))
        {
            throw new \Exception("配置不存在");
        }
        return $option;
    }

}