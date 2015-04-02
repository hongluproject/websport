<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class Member extends \Controller\Admin
{
    public $path = array('member');

    public $menu = array(
        '_h1'           => array('队伍'),
        'member.list'   => array('队伍成员', '/admin/member'),
        'member.edit'   => array('新建成员', '/admin/member/edit'),
    );

    public function get()
    {

    }
}