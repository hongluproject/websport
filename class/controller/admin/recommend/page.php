<?php

namespace Controller\Admin\Recommend;

class Page extends \Controller\Admin\Recommend
{
    public $data;
    public $path = array('recommend', 'recommend.list');
    protected $_tpl = 'admin/recommend/list';
    public function get()
    {

        $acurl = new \Utils\Acurl();
        $result  = $acurl->setOption(array('method'=>'get','class'=>'ActivityRecommend'))->getCurlResult();
        $this->result = json_decode($result);
        $page =  \Model\Core::fetchAsPageByAvos(10,$this->result->count);
        $this->page = $page;
    }

}

