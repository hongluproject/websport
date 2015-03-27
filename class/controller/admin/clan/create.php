<?php

namespace Controller\Admin\Clan;

class Create extends \Controller\Admin\Clan
{
    public $data;
    public $path = array('clan', 'clan.create');
    protected $_tpl = 'admin/clan/create';
    public function get()
    {
        $where = '{"level":1}';
        $acurl = new \Utils\Acurl();
        $result  = $acurl->setOption(array('method'=>'get','class'=>'Tag','where'=>$where))->getCurlResult();
        $this->pids = json_decode($result);

    }


    public  function post(){
        unset($_POST['img']);
        $fields = array();
        $fields['tag_name'] = (string)$_POST['tag_name'];
        $fields['rank'] =  (int)$_POST['rank'];
        if(isset($_POST['pid'])){
            $fields['pid'] = $_POST['pid'];
        }

        if(isset($_POST['status'])){
            $fields['status'] = (int)$_POST['status'];
        }

        if(isset($_POST['level'])){
            $fields['level'] = (int)$_POST['level'];
        }

        if(isset($_POST['level'])){
            $fields['level'] = (int)$_POST['level'];
        }
        if(isset($_POST['icon'])){
            $fields['icon'] = $_POST['icon'];
        }

        if(isset($_POST['hover_icon'])){
            $fields['hover_icon'] = $_POST['hover_icon'];
        }

        if(isset($_POST['clothesTag'])){
            $fields['clothesTag'] = $_POST['clothesTag'];
        }

        if(isset($_POST['alias_name'])){
            $fields['alias_name'] = $_POST['alias_name'];
        }


        $acurl = new \Utils\Acurl();

        $result  = $acurl->setOption(array('method'=>'post','class'=>'Tag','field'=>$fields))->getCurlResult();
        $result = json_decode($result);
        redirect('/admin/tag/list/');

    }

}

