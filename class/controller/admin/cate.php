<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class Cate extends \Controller\Admin
{
    public $path = array('cate');

    public $menu = array(
        '_h1'           => array('分类'),
        'cate.list'   => array('分类列表', '/admin/cate'),
        'cate.edit'   => array('新建分类', '/admin/cate/edit'),
    );
}