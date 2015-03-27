<?php

namespace Controller\Admin;
define('PER_PAGE', 10);

class News extends \Controller\Admin
{
    public $path = array('news');

    public $menu = array(
        '_h1'           => array('新闻'),
        'news.list'   => array('Avos新闻列表', '/admin/news'),
        'news.local'   => array('本地新闻列表', '/admin/news/local'),
     //   'news.map'   => array('当日录入统计', '/admin/news/map'),
        'news.tongji'   => array('历史录入统计', '/admin/news/tongji'),

    );

    public function get()
    {

    }
}