<?php

namespace Controller\Admin\Area;
class Edit extends \Controller\Admin\Area
{
    public $data;
    public $path = array('area', 'area.edit');

    protected $_tpl = 'admin/area/edit';

    public function get($id)
    {
        $acurl = new \Utils\Acurl();
        $where = '{"level":1}';
        $result  = $acurl->setOption(array('method'=>'get','limit'=>100,'class'=>'Area','where'=>$where))->getCurlResult();
        $this->pids = json_decode($result);
        if($id){
            $result  = $acurl->setOption(array('method'=>'get','class'=>'Area','objectId'=>$id))->getCurlResult();
            $this->result = json_decode($result);
        }else{
            $this->result = array();
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
        if(isset($_POST['level'])){
            $_POST['level'] = (int)$_POST['level'];
        }
        if($id){
            if(isset($_POST['pid'])){
                list($pid,$pid_title)= explode(',',$_POST['pid']);
                $_POST['pid'] = $pid;
                if($_POST['level'] ==1){
                    $_POST['province'] = null;
                }else{
                    $_POST['province'] = array('objectId'=>$pid,'title'=>$pid_title);
                }
            }
            $result  = $acurl->setOption(array('method'=>'post','class'=>'Area','objectId'=>$id,'field'=>$_POST))->getCurlResult();
            redirect('/admin/area/edit/'.$id);
        }else{
            if(isset($_POST['pid'])){
                list($pid,$pid_title)= explode(',',$_POST['pid']);
                $_POST['pid'] = $pid;
                if($_POST['level'] ==1){
                    $_POST['province'] = null;
                }else{
                    $_POST['province'] = array('objectId'=>$pid,'title'=>$pid_title);
                }
            }
            $result  = $acurl->setOption(array('method'=>'post','class'=>'Area','field'=>$_POST))->getCurlResult();
            $result = json_decode($result);
            if($result->objectId){
                redirect('/admin/area/edit/'.$result->objectId);
            }else{
                redirect('/admin/area/list/');
            }
        }
    }
}