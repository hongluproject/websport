<?php

namespace Controller\Admin\User;

class Page extends \Controller\Admin\User
{
    public $data;
    public $path = array('user', 'user.list');

    protected $_tpl = 'admin/user/list';

    public function get()
    {
        $this->data = \Model\User::fetch();
     }
}