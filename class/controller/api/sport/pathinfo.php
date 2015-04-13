<?php
namespace Controller\Api\Sport;

class Pathinfo extends \Controller\Api
{
    public function get()
    {


        $phone = $_GET['phone'];


        $siteModel = new \Model\Site();
        $where = array('lineId'=>'03');
        $sites = $siteModel->fetch($where, 1000);

        $pathInfo = array();

        foreach($sites as $item){
            $pathInfo[$item->siteId] =  array('memberStatus'=>'3','passTime'=>null,'address'=>$item->position);
        }

        echo json_encode(array('status'=>1,'message'=>'OK','passurl'=>'http://www.baidu.com','result'=>$pathInfo));
    }

    public function post()
    {

    }
}

