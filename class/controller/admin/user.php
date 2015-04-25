<?php

namespace Controller\Admin;

class User extends \Controller\Admin
{
    public $path = array('user');
    public $menu = array(
        '_h1' => array('用户管理'),
        'user.list'   => array('用户列表', '/admin/user/list'),
    	'user.add'   => array('添加用户', '/admin/user/add'),
        'user.download'   => array('导出登协管理员', '/admin/user/download'),
        'user.message'   => array('短消息群发', '/admin/user/message'),

    );

    public function get()
    {

    }
}