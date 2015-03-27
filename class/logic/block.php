<?php

namespace Logic;

class Block
{

    /**
     * 批量获取
     * @static
     * @param $data
     * @return \Model\Redis\Option
     */
    public static function fetch()
    {
        return \Model\Block::fetch();
    }
	
	/**
     * 分页批量获取
     * @static
     * @param $data
     * @return \Model\Redis\Block
     */
    public static function fetchAsPageByQuery(array $where = NULL, $num = 1, array $order_by = null, $path = null)
    {
        return \Model\Block::fetchAsPageByQuery( $where, $num, $order_by, $path);
    }

    /**
     * 分页批量获取
     * @static
     * @param $data
     * @return \Model\Redis\Block
     */
    public static function fetchAsPage(array $where = NULL, $page = 1, $num = 10, array $order_by = null, $path = null)
    {
        return \Model\Block::fetchAsPage( $where, $page, $num, $order_by, $path);
    }


    /**
     * 创建禁用信息
     *
     * @static
     * @param $data
     * @return \Model\Option
     */
    public static function create($data)
    {
        $option = new \Model\Block();
        $option->set($data);
        $option->save();
        return $option;
    }

    /**
     * 更新禁用信息
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
     * 删除禁用信息
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
        if (!$option = \Model\Block::find($id))
        {
            throw new \Exception("配置不存在");
        }
        return $option;
    }
	
}