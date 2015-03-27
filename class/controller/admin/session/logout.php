<?php

namespace Controller\Admin\Session;

class Logout extends \Controller\Admin\Session
{
    protected $_login = false;

    public function get()
    {
        \Logic\User::logout();
        $_SERVER['SERVER_NAME'] = $_SERVER['HTTP_HOST'];
        redirect('/admin/session/login');
    }
}