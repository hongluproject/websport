<?php

namespace Controller\Admin\Tag;

class Create extends \Controller\Admin\Tag
{
    public $data;
    public $path = array('tag', 'tag.create');
    protected $_tpl = 'admin/tag/create';
    public function get()
    {

        $acurl = new \Utils\Acurl();
        $this->tagdirectory  = json_decode($acurl->setOption(array('method'=>'get','class'=>'TagDirectory','limit'=>'1000'))->getCurlResult(),true);
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

        if(isset($_POST['fetch_rule'])){
            $fields['fetch_rule'] = (int)$fields['fetch_rule'];
        }

        if(isset($_POST['tagDirectoryId'])){
            $fields['tagDirectoryId'] =array('__type'=>'Pointer','className'=>'TagDirectory','objectId'=>$_POST['tagDirectoryId']);
        }
        //{"__type":"Pointer","className":"Player","objectId":"51c3ba67e4b0f0e851c16221"}
        $acurl = new \Utils\Acurl();
        $result  = $acurl->setOption(array('method'=>'post','class'=>'Tag','field'=>$fields))->getCurlResult();
        $result = json_decode($result);
        redirect('/admin/tag/list/');

    }

}

