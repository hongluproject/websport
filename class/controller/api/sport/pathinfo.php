<?php
namespace Controller\Api\Sport;

class Pathinfo extends \Controller\Api
{
    public function get()
    {

        $pathInfo = array('status'=>1,'message'=>'OK','passurl'=>'http://www.baidu.com',
                    'result'=>array(array('status'=>1,'message'=>'通关','passTime'=>date('Y-m-d H:i:s'),'address'=>'下关在哪里'),
                    array('status'=>2,'message'=>'02','passTime'=>date('Y-m-d H:i:s'),'address'=>'下关在哪里1'),
                    array('status'=>3,'message'=>'03','passTime'=>date('Y-m-d H:i:s'),'address'=>'下关在哪里12'),
                    array('status'=>3,'message'=>'04','passTime'=>null,'address'=>'')),
        );
        echo   json_encode($pathInfo);
        //运动员自己的

    }

    public function post()
    {

    }
}

