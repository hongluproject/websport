<?php

namespace Controller\Admin\Avosuser;

class Page extends \Controller\Admin\Avosuser
{
    public $data;
    public $path = array('avosuser', 'avosuser.list');

    protected $_tpl = 'admin/avosuser/list';

    public function get()
    {

        $searchParam = array('$or'=>array(array('nickname' => array('$regex'=>$_GET['title'])),array('username' => array('$regex'=>$_GET['title']))));
        $acurl = new \Utils\Acurl();
        $result = $acurl->setOption(array('method' => 'get', 'class' => '_User','where' => json_encode($searchParam)))->getCurlResult();
        $this->result = json_decode($result);
        $page = \Model\Core::fetchAsPageByAvos(10, $this->result->count);
        $this->page = $page;
    }

    public function post()
    {
        $_GET = $_POST;
        $this->get();
    }

}

