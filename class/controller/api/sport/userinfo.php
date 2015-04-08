<?php
namespace Controller\Api\Sport;

class Userinfo extends \Controller\Api
{
    public function get()
    {
        $pathInfo = array('1'=>array('status'=>1,'message'=>'通关','passTime'=>date('Y-m-d H:i:s'),'address'=>'下关在哪里'),
            '2'=>array('status'=>2,'message'=>'未知','passTime'=>date('Y-m-d H:i:s'),'address'=>'下关在哪里1'),
            '3'=>array('status'=>3,'message'=>'正常通关','passTime'=>date('Y-m-d H:i:s'),'address'=>'下关在哪里12'),
        );
        echo   json_encode($pathInfo);
        //运动员自己的
    }

    public function post()
    {

    }
}

