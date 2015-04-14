<?php
namespace Controller\Api\Sport;

class Pathinfo extends \Controller\Api
{
    public function get()
    {
        $phone = $_GET['phone'];
        if (!$phone) {
            echo json_encode(array('status' => 2, 'message' => '没有用户信息'));
        }

        $memberModel = new \Model\Member();
        $where = array('phone' => $phone);
        $member = $memberModel->find($where);
        if ($member) {
            $lineId = $member->lineId;
            $teamId = $member->teamId;
            if ($teamId) {
                $teamModel = new \Model\Team();
                $where = array('teamId' => $teamId);
                $team = $teamModel->find($where);
                if ($team) {
                    $passInfo = $team->pathInfo;
                    //todo
                    $passInfo = (array)json_decode($passInfo, true);

                    $siteModel = new \Model\Site();
                    $where = array('lineId' => $lineId);
                    $sites = $siteModel->fetch($where, 1000);
                    ksort($passInfo);
                    end($passInfo);
                    $lastPassInfoKey = key($passInfo);
                    $nextKeyArray = list($lineId,$siteId) = explode('-',$lastPassInfoKey);
                    if(is_array($passInfo)){
                        $nextSiteKey = $siteId+1;
                    }else{
                        $nextSiteKey = 0;
                    }
                    $pathInfo = array();
                    //路程.
                    foreach ($sites as $item) {
                        $pathInfo[$item->siteId] = array('memberStatus' => 3, 'passTime' => null, 'address' => '');

                        if($nextSiteKey == $item->siteId){
                            $pathInfo[$nextSiteKey]['address'] = array('memberStatus' => 3, 'passTime' => null, 'address' => $item->position);
                        }
                        if (array_key_exists($item->lineId . '-' . $item->siteId, $passInfo)) {
                            $pathInfo[$item->siteId]['memberStatus'] = $passInfo[$item->lineId . '-' . $item->siteId]['memberStatus'];
                            $pathInfo[$item->siteId]['passTime'] = $passInfo[$item->lineId . '-' . $item->siteId]['passTime'];
                            $pathInfo[$item->siteId]['lineSite'] = $passInfo[$item->lineId . '-' . $item->siteId];
                            $pathInfo[$item->siteId]['address'] = $item->position;
                        }
                    }
                    echo json_encode(array('status' => 1, 'message' => 'OK', 'passurl' => 'http://www.baidu.com', 'result' => $pathInfo));

                } else {
                    echo json_encode(array('status' => 2, 'message' => '没有TEAM'));
                }
            } else {
                echo json_encode(array('status' => 2, 'message' => '没有TEAM'));
            }
        } else {
            echo json_encode(array('status' => 2, 'message' => '没有此用户'));
        }
    }

    public function post()
    {
    }
}

