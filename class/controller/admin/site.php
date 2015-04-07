<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class Site extends \Controller\Admin
{
    public $path = array('site');

    public $menu = array(
        '_h1' => array('站点'),
        'site.list' => array('点标列表', '/admin/site'),
        'site.edit' => array('新建点标', '/admin/site/edit'),
    );

    public function get()
    {
    }
}