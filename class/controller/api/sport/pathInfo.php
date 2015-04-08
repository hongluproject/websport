<?php
namespace Controller\Api\Sport;

class PathInfo extends \Controller\Api
{
    public function get()
    {
        $pathInfo = array('01-1'=>array('status'=>1,'message'=>'通关','passTime'=>date('Y-m-d H:i:s')),
            '01-2'=>array('status'=>2,'message'=>'未知','passTime'=>date('Y-m-d H:i:s')),
            '01-3'=>array('status'=>3,'message'=>'正常通关','passTime'=>date('Y-m-d H:i:s')),
        );
        echo   json_encode($pathInfo);
        //运动员自己的

    }

    public function post()
    {

    }
}

