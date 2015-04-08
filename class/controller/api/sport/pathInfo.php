<?php
namespace Controller\Api\Sport;

class Pathinfo extends \Controller\Api
{
    public function get()
    {

        $pathInfo = array('status'=>1,'message'=>'OK','result'=>array(array('status'=>1,'message'=>'通关','passTime'=>date('Y-m-d H:i:s'),'address'=>'下关在哪里'),
                    array('status'=>2,'message'=>'未知','passTime'=>date('Y-m-d H:i:s'),'address'=>'下关在哪里1'),
                    array('status'=>3,'message'=>'正常通关','passTime'=>date('Y-m-d H:i:s'),'address'=>'下关在哪里12'),
                    array('status'=>3,'message'=>'正常通关','passTime'=>null,'address'=>'')),
        );
        echo   json_encode($pathInfo);
        //运动员自己的

    }

    public function post()
    {

    }
}

