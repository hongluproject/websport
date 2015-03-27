<?php

namespace Logic;

class User
{
    /**
     * 获取登陆
     *
     * @static
     * @return bool|int|\Model\User
     */
    public static function getLogged()
    {
        static $user = array();
        if (!empty($user)) return $user;
        //TODO
        if (!$_SESSION['user_id']) return false;
        if ($user = self::find($_SESSION['user_id']))
        {
            return $user;
        }
        return false;
    }

    /**
     * 登陆
     *
     * @static
     * @param $username
     * @param $password
     * @return bool
     */
    public static function loginWithCas()
    {

        if (empty($attr)) throw new \Exception('用户数据不足，无法登陆');

        $user = \Model\User::find(array('username' => $attr['sAMAccountName']));

        if (!$user)
        {
            $user = new \Model\User();
        }
        $user->username = $attr['sAMAccountName'];
        $user->name = $attr['Name'];
        $user->mobile = $attr['Mobile'];
        $user->department = $attr['Department'];
        $user->mail = $attr['Mail'];
        $user->tel = $attr['Tel'];
        if (in_array($user->username, config('cas.admin')))
        {
            //设置为管理员
            $user->admin = 1;
            // 默认激活
            $user->status = 1;
        }
        $user = $user->save();
        $_SESSION['user_id'] = $user->id;
        return $user;
    }

    /**
     * 激活用户
     * @static
     * @param $id
     * @return mixed
     */
    public static function active($id)
    {
        $user = self::find($id);
        $user->status = 1;
        return $user->save();
    }

    /**
     * 取消激活用户
     * @static
     * @param $id
     * @return mixed
     */
    public static function deActive($id)
    {
        $user = self::find($id);
        $user->status = 0;
        return $user->save();
    }

    /**
     * 登出
     *
     * @static
     * @return bool
     */
    public static function logout()
    {
        \Core\Session::destroy();
        return true;
    }

    /**
     * 创建用户
     *
     * @static
     * @param $data
     * @return \Model\User
     */
    public static function create($data)
    {
        $user = new \Model\User();
        $user->set($data);
        $user->save();
        return $user;
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
        $user = self::find($id);
        if ($user)
        {
            $user->set($data);
        }
        $user->save();
        return $user;
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
        $user = self::find($id);
        return $user->delete();
    }

    /**
     * @static
     * @param $id
     * @return bool|int|\Model\User
     * @throws \Exception
     */
    public static function find($id)
    {
        if (!$user = \Model\User::find($id))
        {
            throw new \Exception("用户不存在");
        }
        return $user;
    }
}