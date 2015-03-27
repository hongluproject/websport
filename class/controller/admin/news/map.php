<?php

namespace Controller\Admin\News;

class Map extends \Controller\Admin\News
{
    public $path = array('news', 'news.map');
    protected $_tpl = 'admin/news/map';

    public function get()
    {
        $db = \Model\Fetch::db();
        $today_begin = date('Y-m-d 00:00:00');
        $query =  'select tags from news where `status` = 3 and `modify_time`>"'.$today_begin .'"';
        $query_data = $db->fetch($query);

        $news_tags = array();
        foreach($query_data as $item){
            if($item->tags){
                $news_tags = array_merge($news_tags,explode(',',$item->tags));
            }
        }
        $this->news_tags_count = array_count_values($news_tags);

        $acurl = new \Utils\Acurl();
        $result  = $acurl->setOption(array('method'=>'get','class'=>'Tag','limit'=>1000))->getCurlResult();
        $this->avos_tags = json_decode($result)->results;

    }


    public function getPath()
    {

        $page = (int)isset($_POST['page'])?$_POST['page']:1;
        if ($page < 1) $page = 1;
        $query = $_POST;
        if (!empty($query))
        {
            foreach ($query as $k => $v)
            {
                if(!$v){
                    unset($query[$k]);
                    continue;
                }
                $query[$k] = urlencode($k) . "=" . urlencode($v);
            }
            $path = PATH . '?' . join('&', $query) . '&page=:page';
        }
        else
        {
            $path = PATH . '?' . 'page=:page';
        }
        return $path;

    }

}