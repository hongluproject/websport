<?php

namespace Controller\Admin;

class User extends \Controller\Admin
{
    public $path = array('user');
    public $menu = array(
        '_h1' => array('用户管理'),
        'user.list'   => array('用户列表', '/admin/user/list'),
    	'user.add'   => array('添加用户', '/admin/user/add'),
    );

    public function get()
    {

    }
}