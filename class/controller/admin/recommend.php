<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class Recommend extends \Controller\Admin
{
    public $path = array('recommend');

    public $menu = array(
        '_h1'           => array('推荐'),
        'cate.list'   => array('推荐列表', '/admin/recommend'),
        'cate.edit'   => array('新建推荐', '/admin/recommend/edit'),
    );
}