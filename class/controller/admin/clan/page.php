<?php

namespace Controller\Admin\Clan;

class Page extends \Controller\Admin\Clan
{
    public $data;
    public $path = array('clan', 'clan.list');
    protected $_tpl = 'admin/clan/list';
    public function get()
    {
        $acurl = new \Utils\Acurl();
        $result  = $acurl->setOption(array('method'=>'get','class'=>'Tag'))->getCurlResult();
        $this->result = json_decode($result);
        $page =  \Model\Core::fetchAsPageByAvos(10,$this->result->count);
        $this->page = $page;
    }

}

