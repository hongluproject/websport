<?php

namespace Logic;

class Option
{

    /**
     * 批量获取
     * @static
     * @param $data
     * @return \Model\Redis\Option
     */
    public static function fetch()
    {
        return \Model\Option::fetch();
    }

    /**
     * 创建用户
     *
     * @static
     * @param $data
     * @return \Model\Option
     */
    public static function create($data)
    {
        $option = new \Model\Option();
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
        if (!$option = \Model\Option::find($id))
        {
            throw new \Exception("配置不存在");
        }
        return $option;
    }
}