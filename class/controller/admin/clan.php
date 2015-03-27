<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class Clan extends \Controller\Admin
{
    public $path = array('clan');

    public $menu = array(
        '_h1'           => array('标签'),
        'clan.list'   => array('部落列表', '/admin/clan'),
        'clan.create'   => array('部落标签', '/admin/clan/create'),
    );
}