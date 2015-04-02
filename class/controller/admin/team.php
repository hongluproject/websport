<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class Team extends \Controller\Admin
{
    public $path = array('team');

    public $menu = array(
        '_h1'           => array('队伍'),
        'team.list'   => array('队伍列表', '/admin/team'),
        'team.edit'   => array('新建队伍', '/admin/team/edit'),
    );

    public function get()
    {

    }
}