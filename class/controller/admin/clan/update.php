<?php

namespace Controller\Admin\Clan;
class Update extends \Controller\Admin\Clan
{
    public $data;
    public $path = array('clan', 'clan.list');

    protected $_tpl = 'admin/clan/edit';

    public function get($id)
    {

        $where = '{"level":1}';
        $acurl = new \Utils\Acurl();
        $pids  = $acurl->setOption(array('method'=>'get','class'=>'Tag','where'=>$where))->getCurlResult();
        $this->pids = json_decode($pids);

        $result  = $acurl->setOption(array('method'=>'get','class'=>'Tag','objectId'=>$id))->getCurlResult();
        $this->result = json_decode($result);

    }

    public function post($id){

        unset($_POST['img']);
        $acurl = new \Utils\Acurl();
        if(isset($_POST['rank'])){
            $_POST['rank'] = (int)$_POST['rank'];
        }
        if(isset($_POST['status'])){
            $_POST['status'] = (int)$_POST['status'];
        }
        if(isset($_POST['level'])){
            $_POST['level'] = (int)$_POST['level'];
        }
        $result  = $acurl->setOption(array('method'=>'post','class'=>'Tag','objectId'=>$id,'field'=>$_POST))->getCurlResult();
        redirect('/admin/tag/update/'.$id);

    }
}