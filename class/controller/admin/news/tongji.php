<?php

namespace Controller\Admin\News;
class Tongji extends \Controller\Admin\News
{
    public $data;
    public $path = array('news', 'news.tongji');
    protected $_tpl = 'admin/news/tongji';
    public $searchParam = array();


    public function get()
    {
        //step1:获取所有标签
        $acurl = new \Utils\Acurl();
        //下面我要做一个很SB的事。
        $dateObj = array();
        if ($this->searchParam['start_date']) {
            $startDateObj = array('iso' => date('Y-m-d\T00:00:01.000\Z', strtotime($this->searchParam['start_date'])), '__type' => 'Date');
            $dateObj = array_merge($dateObj, array('$gte' => $startDateObj));
        }
        if ($this->searchParam['end_date']) {
            $endDateObj = array('iso' => date('Y-m-d\T23:59:59.000\Z', strtotime($this->searchParam['end_date'])), '__type' => 'Date');
            $dateObj = array_merge($dateObj, array('$lte' => $endDateObj));
        }
        if ($dateObj) {
            $where = json_encode(array('createdAt' => $dateObj));
            $option = array('method' => 'get', 'limit' => 1000, 'class' => 'News', 'keys' => 'tags', 'where' => $where);
        } else {
            $option = array('method' => 'get', 'limit' => 1000, 'class' => 'News', 'keys' => 'tags');
        }
        $news_result = json_decode($acurl->setOption($option)->getCurlResult())->results;
        $tags_merge = array();
        foreach ($news_result as $item) {
            if (!$item->tags)
                continue;
            $tags_merge = array_merge($tags_merge, $item->tags);
        }
        //step2:划分父,子目录
        $tags_count_values = array_count_values($tags_merge);
        $option = array('method' => 'get', 'limit' => 1000, 'class' => 'Tag');
        $tag_result = json_decode($acurl->setOption($option)->getCurlResult())->results;
        $p_tags = array();
        $c_tags = array();
        foreach ($tag_result as $item) {
            if ($item->level == 1) {
                $p_tags[$item->objectId] = $item;

            } elseif ($item->level == 2) {
                $item->count = $tags_count_values[$item->objectId] ? $tags_count_values[$item->objectId] : 0;
                $c_tags[$item->pid][] = $item;
            }
        }
        foreach ($p_tags as $key => $item) {
            $p_tags[$key]->subTree = $c_tags[$key];
        }
        $this->p_tags = $p_tags;
    }

    public function post()
    {
        if ($_POST['start_date']) {
            $this->searchParam['start_date'] = $_POST['start_date'];;
        }
        if ($_POST['end_date']) {
            $this->searchParam['end_date'] = $_POST['end_date'];
        }
        $this->get();
    }
}