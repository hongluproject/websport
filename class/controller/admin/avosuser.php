<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class Avosuser extends \Controller\Admin
{
    public $path = array('avosuser');

    public $menu = array(
        '_h1'           => array('avosuser'),
        'avosuser.list'   => array('注册用户列表', '/admin/avosuser'),
     );
}