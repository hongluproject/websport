<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class Signup extends \Controller\Admin
{
    public $path = array('signup');

    public $menu = array(
        '_h1' => array('点标'),
        'signup.list' => array('报名列表', '/admin/signup'),
        'signup.edit' => array('新建报名', '/admin/signup/edit'),
    );

    public function get()
    {
    }
}