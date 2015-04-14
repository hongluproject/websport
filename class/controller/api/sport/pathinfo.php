<?php
namespace Controller\Api\Sport;

class Pathinfo extends \Controller\Api
{
    public function get()
    {
        $phone = $_GET['phone'];
        $siteModel = new \Model\Site();
        $memberModel = new \Model\Member();
        $where = array('phone' => $phone);
        $member = $memberModel->fetch($where, 100);

        if($member[0]){
            $lineId = $member[0]->lineId;
            $teamId = $member[0]->teamId;
            if ($teamId) {
                $teamModel = new \Model\Team();
                $where = array('teamId' => $teamId);
                $team = $teamModel->fetch($where, 1);
                if($team[0]){
                    $passInfo = $team[0]->pathInfo;
                }
            }
        }


        $passInfo  = (array)json_decode($passInfo,true);
        $where = array('lineId'=>$lineId);
        $sites = $siteModel->fetch($where, 1000);
        $pathInfo = array();

        foreach($sites as $item){
            $pathInfo[$item->lineId.'-'.$item->siteId] =  array('memberStatus'=>'3','passTime'=>null,'address'=>$item->position);
            if(array_key_exists($item->lineId.'-'.$item->siteId,$passInfo)){
                $pathInfo[$item->lineId.'-'.$item->siteId]['memberStatus'] =  $passInfo[$item->lineId.'-'.$item->siteId]['memberStatus'];
                $pathInfo[$item->lineId.'-'.$item->siteId]['passTime'] =  $passInfo[$item->lineId.'-'.$item->siteId]['passTime'];
            }
        }
        echo json_encode(array('status'=>1,'message'=>'OK','passurl'=>'http://www.baidu.com','result'=>$pathInfo));
    }

    public function post()
    {

    }
}

