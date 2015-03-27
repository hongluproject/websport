<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class Fetch extends \Controller\Admin
{
    public $path = array('fetch');
    public $menu = array(
        '_h1'           => array('蜘蛛'),
        'fetch.list'   => array('蜘蛛列表', '/admin/fetch'),
        'fetch.edit'   => array('微信详情定向抓取', '/admin/fetch/edit'),
        'fetch.create'    => array('微信蜘蛛抓取', '/admin/fetch/create'),
        'fetch.zixunfetch'   => array('1点资讯抓取', '/admin/fetch/zixunfetch'),
    );
    public function get()
    {
    }
}