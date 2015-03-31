<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class Line extends \Controller\Admin
{
    public $path = array('line');

    public $menu = array(
        '_h1'           => array('线路'),
        'line.list'   => array('线路列表', '/admin/line'),
        'line.edit'   => array('新建线路', '/admin/line/edit'),
    );

    public function get()
    {

    }
}