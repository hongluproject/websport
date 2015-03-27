<?php

namespace Controller\Admin\Avosuser;
class Edit extends \Controller\Admin\Avosuser
{
    public $data;
    public $path = array('avosuser', 'avosuser.edit');

    protected $_tpl = 'admin/avosuser/edit';

    public function get($id)
    {
        //用户信息
        $acurl = new \Utils\Acurl();
        $result  = $acurl->setOption(array('method'=>'get','class'=>'_User','objectId'=>$id))->getCurlResult();
        $this->result = json_decode($result);

        //标签
        $tag_result  = $acurl->setOption(array('method'=>'get','class'=>'Tag','limit'=>1000))->getCurlResult();
        $tags_arr =  $clan_arr = array();
        foreach (json_decode($tag_result)->results as $item){
            $tags_arr[$item->objectId] = $item->tag_name;
        }

        //部落
        $clan_result  = $acurl->setOption(array('method'=>'get','class'=>'Clan','limit'=>1000))->getCurlResult();
         foreach (json_decode($clan_result)->results as $item){
             $clan_arr[$item->objectId] = $item->title;
        }
        $this->tags_arr = $tags_arr;
        $this->clan_arr = $clan_arr;


    }

    public function post($id){

    }
}