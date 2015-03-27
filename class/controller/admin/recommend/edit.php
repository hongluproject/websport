<?php

namespace Controller\Admin\Recommend;
class Edit extends \Controller\Admin\Recommend
{
    public $data;
    public $path = array('recommend', 'recommend.edit');
    protected $_tpl = 'admin/recommend/edit';
    public function get($id)
    {
        if($id){
            $acurl = new \Utils\Acurl();
            $result  = $acurl->setOption(array('method'=>'get','class'=>'ActivityRecommend','objectId'=>$id))->getCurlResult();
            $this->result = json_decode($result);
        }else{
            $this->result = array();
        }
    }

    public function post($id){

        $acurl = new \Utils\Acurl();
        if(isset($_POST['status'])){
            $_POST['status'] = (int)$_POST['status'];
        }
        $_POST['activityId'] = array('__type'=>'Pointer','className'=>'Activity','objectId'=>$_POST['activityId']);
        if($id){
            $result  = $acurl->setOption(array('method'=>'post','class'=>'ActivityRecommend','objectId'=>$id,'field'=>$_POST))->getCurlResult();
            redirect('/admin/recommend/edit/'.$id);
        }else{

            $result  = $acurl->setOption(array('method'=>'post','class'=>'ActivityRecommend','field'=>$_POST))->getCurlResult();
            $result = json_decode($result);
            if($result->objectId){
                redirect('/admin/recommend/edit/'.$result->objectId);
            }else{
                redirect('/admin/recommend/list');
            }
        }

    }
}