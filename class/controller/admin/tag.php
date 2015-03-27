<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class Tag extends \Controller\Admin
{
    public $path = array('news');

    public $menu = array(
        '_h1'           => array('标签'),
        'tag.list'   => array('标签列表', '/admin/tag'),
        'tag.create'   => array('新建标签', '/admin/tag/create'),
        'tag.menucreate'   => array('新建目录', '/admin/tag/menucreate'),

    );
}