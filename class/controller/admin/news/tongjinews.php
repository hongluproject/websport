<?php

namespace Controller\Admin\News;
class Tongjinews extends \Controller\Admin\News
{
    public $data;
    public $path = array('news', 'news.tongjinews');
    protected $_tpl = 'admin/news/tongjinews';
    protected $_layout = 'admin/cleanlayout';

    public $searchParam = array();


    public function get()
    {

        if(!$_GET['objectId']){
            $this->result = array();
            return;
        }
        //step1:获取$objectID 去avos
        $acurl = new \Utils\Acurl();
        $dateObj = $objArr = array();
        if ($_GET['start_date']) {
            $startDateObj = array('iso' => date('Y-m-d\T00:00:01.000\Z', strtotime($_GET['start_date'])), '__type' => 'Date');
            $dateObj = array_merge($dateObj, array('$gte' => $startDateObj));
        }
        if ($_GET['end_date']) {
            $endDateObj = array('iso' => date('Y-m-d\T23:59:59.000\Z', strtotime($_GET['end_date'])), '__type' => 'Date');
            $dateObj = array_merge($dateObj, array('$lte' => $endDateObj));
        }
        if ($_GET['objectId']) {
            $tags = array('tags'=>array('$all'=>array($_GET['objectId'])));
        }
        //{"title": {$regex:"钓鱼"}}
        if ($dateObj) {
            $dateObj = array('createdAt' => $dateObj);
        }
        $where = array_merge($dateObj, $tags);
        $result = $acurl->setOption(array('method' => 'get', 'limit' => 1000, 'class' => 'News','keys' => 'tags,title', 'where' => json_encode($where)))->getCurlResult();
        $this->result = json_decode($result);
    }
}