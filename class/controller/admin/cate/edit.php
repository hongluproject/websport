<?php

namespace Controller\Admin\Cate;
class Edit extends \Controller\Admin\Cate
{
    public $data;
    public $path = array('cate', 'cate.edit');

    protected $_tpl = 'admin/cate/edit';

    public function get($id)
    {
        if($id){
            $acurl = new \Utils\Acurl();
            $result  = $acurl->setOption(array('method'=>'get','class'=>'Cate','objectId'=>$id))->getCurlResult();
            $this->result = json_decode($result);
        }else{
            $this->result= array();
        }
    }

    public function post($id){
        $acurl = new \Utils\Acurl();
        if(isset($_POST['rank'])){
            $_POST['rank'] = (int)$_POST['rank'];
        }
        if(isset($_POST['status'])){
            $_POST['status'] = (int)$_POST['status'];
        }
        if($id){
            $result  = $acurl->setOption(array('method'=>'post','class'=>'Cate','objectId'=>$id,'field'=>$_POST))->getCurlResult();
            redirect('/admin/cate/edit/'.$id);
        }else{
            $result  = $acurl->setOption(array('method'=>'post','class'=>'Cate','field'=>$_POST))->getCurlResult();
            $result = json_decode($result);
            if($result->objectId){
                redirect('/admin/cate/edit/'.$result->objectId);
            }else{
                redirect('/admin/cate/list/');
            }
        }
    }
}