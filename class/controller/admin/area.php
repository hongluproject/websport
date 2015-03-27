<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class Area extends \Controller\Admin
{
    public $path = array('area');

    public $menu = array(
        '_h1'           => array('地区'),
        'area.list'   => array('地区列表', '/admin/area'),
        'area.edit'   => array('新建地区列表', '/admin/area/edit'),

    );

    public function get()
    {

    }
}