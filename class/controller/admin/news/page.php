<?php

namespace Controller\Admin\News;
class Page extends \Controller\Admin\News
{
    public $data;
    public $path = array('news', 'news.list');
    public $searchParam = array();
    protected $_tpl = 'admin/news/list';
    public function get()
    {
        $dateObj = $titleObj = array();
        if ($_GET['start_date']) {
            $startDateObj = array('iso' => date('Y-m-d\T00:00:01.000\Z', strtotime($_GET['start_date'])), '__type' => 'Date');
            $dateObj = array_merge($dateObj, array('$gte' => $startDateObj));
        }
        if ($_GET['end_date']) {
            $endDateObj = array('iso' => date('Y-m-d\T23:59:59.000\Z', strtotime($_GET['end_date'])), '__type' => 'Date');
            $dateObj = array_merge($dateObj, array('$lte' => $endDateObj));
        }
        if ($_GET['title']) {
            $titleObj = array('title' => array('$regex'=>$_GET['title']));
        }
        //{"title": {$regex:"钓鱼"}}
        if ($dateObj) {
            $dateObj = array('createdAt' => $dateObj);
        }

        $where = array_merge($dateObj, $titleObj);
        $acurl = new \Utils\Acurl();
        if ($where) {
            $result = $acurl->setOption(array('method' => 'get','keys'=>'objectId,title,contents_url,createdAt,comment_count,up_count','class' => 'News', 'where' => json_encode($where)))->getCurlResult();
        } else {
            $result = $acurl->setOption(array('method' => 'get', 'keys'=>'objectId,title,contents_url,createdAt,comment_count,up_count','class' => 'News'))->getCurlResult();
        }

        $this->result = json_decode($result);
        $page = \Model\Core::fetchAsPageByAvos(10, $this->result->count);
        $this->page = $page;
        $this->searchParam = $_GET;
    }

    public function post()
    {
        if ($_POST['start_date']) {
            $_GET['start_date'] = $_POST['start_date'];;
        }
        if ($_POST['end_date']) {
            $_GET['end_date'] = $_POST['end_date'];
        }
        if ($_POST['title']) {
            $_GET['title'] = $_POST['title'];
        }
        $this->get();
    }

}