<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class Mission extends \Controller\Admin
{
    public $path = array('mission');

    public $menu = array(
        '_h1'           => array('任务'),
        'mission.list'   => array('任务列表', '/admin/mission'),
        'mission.edit'   => array('新建任务', '/admin/mission/edit'),
    );

    public function get()
    {

    }
}