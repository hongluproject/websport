<?php
namespace Controller\Api\Sport;

class Scan extends \Controller\Api
{
    public function get()
    {
        $type = $_GET['type'];
        if(!$type){
            echo  json_encode(array('status'=>2,'message'=>'没有type'));
            exit;
        }else if(!$_GET['phone']){
            echo  json_encode(array('status'=>2,'message'=>'没有注册号'));
        }else{
              if($type== 1){
                  // todo input databaase;
                  echo json_encode(array('status'=>1,'message'=>'下面是任务','result'=>array('type'=>$type,'title'=>'任务描述。这个你这次跳楼一百次','url'=>'http://www.baidu.com')));
              }elseif($type == 2){
                  //todo input databases;
                  echo  json_encode(array('status'=>1,'message'=>'顺利通关','result'=>array('type'=>$type,'isFinal'=>false)));
              }
        }
    }

    public function post()
    {

    }
}
