<?php

namespace Controller\Admin\Cate;

class Page extends \Controller\Admin\Cate
{
    public $data;
    public $path = array('cate', 'cate.list');
    protected $_tpl = 'admin/cate/list';
    public function get()
    {
        $acurl = new \Utils\Acurl();
        $result  = $acurl->setOption(array('method'=>'get','class'=>'Cate'))->getCurlResult();
        $this->result = json_decode($result);
        $page =  \Model\Core::fetchAsPageByAvos(10,$this->result->count);
        $this->page = $page;
    }
}