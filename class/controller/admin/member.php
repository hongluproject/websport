<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class Member extends \Controller\Admin
{
    public $path = array('area');

    public $menu = array(
        '_h1'           => array('队伍'),
        'member.list'   => array('队伍列表', '/admin/member'),
        'member.edit'   => array('新建队伍', '/admin/member/edit'),
    );

    public function get()
    {

    }
}