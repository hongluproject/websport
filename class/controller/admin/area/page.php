<?php

namespace Controller\Admin\Area;

class Page extends \Controller\Admin\Area
{
    public $data;
    public $path = array('area', 'area.list');
    protected $_tpl = 'admin/area/list';
    public function get()
    {
        $acurl = new \Utils\Acurl();
        $result  = $acurl->setOption(array('method'=>'get','class'=>'Area'))->getCurlResult();
        $this->result = json_decode($result);
        $page =  \Model\Core::fetchAsPageByAvos(10,$this->result->count);
        $this->page = $page;
    }

}