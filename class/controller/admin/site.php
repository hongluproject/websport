<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class Site extends \Controller\Admin
{
    public $path = array('site');

    public $menu = array(
        '_h1' => array('站点'),
        'site.list' => array('站点列表', '/admin/site'),
        'site.edit' => array('新建站点', '/admin/site/edit'),
    );

    public function get()
    {
    }
}