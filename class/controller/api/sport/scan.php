<?php
namespace Controller\Api\Sport;

class Scan extends \Controller\Api
{
    public function get()
    {
        //站点
        $siteId = $_GET['siteId'];
        //线路
        $lineId = $_GET['lineId'];
        $phone = $_GET['phone'];
        //所处段
        $position = $_GET['position'];
        //1任务信息 2是 过关信息
        $type = $_GET['type'];
        if (!$type) {
            echo json_encode(array('status' => 2, 'message' => '没有type'));
        } else if (!$phone) {
            echo json_encode(array('status' => 2, 'message' => '没有录入手机号码'));
        } else if (!isset($siteId)) {
            echo json_encode(array('status' => 2, 'message' => '没有站点信息'));
        } else if (!$lineId) {
            echo json_encode(array('status' => 2, 'message' => '没有线路信息'));
        } else {
            $memberModel = new \Model\Member();
            $where = array('phone' => $phone);
            $member = $memberModel->find($where);
            if ($member) {
                //找到member
                $teamId = $member->teamId;
                if ($teamId) {
                    $teamModel = new \Model\Team();
                    $where = array('teamId' => $teamId);
                    $team = $teamModel->find($where);
                    //找到team
                    if ($team) {
                        if ($type == 2) {
                            $passInfo = (array)json_decode($team->pathInfo, true);
                            if (array_key_exists($lineId . '-' . $siteId, $passInfo)) {
                                if ($position == 3) {
                                    echo json_encode(array('status' => 1, 'message' => '已经扫描过关卡', 'result' => array('type' => $type, 'isFinal' => true, 'passurl' => 'http://www.baidu.com')));
                                } else {
                                    echo json_encode(array('status' => 1, 'message' => '已经扫描过关卡', 'result' => array('type' => $type, 'isFinal' => false)));
                                }
                            } else {
                                $passInfo[$lineId . '-' . $siteId] = array('memberStatus' => 1, 'passTime' => date('Y-m-d H:i:s'));
                                $teamInfo = \Model\Team::find($team->id);
                                $param['pathInfo'] = json_encode($passInfo);
                                $teamInfo->set($param);
                                $teamInfo->save();
                                if ($position == 3) {
                                    echo json_encode(array('status' => 1, 'message' => '顺利通关', 'result' => array('type' => $type, 'isFinal' => true, 'passurl' => 'http://www.baidu.com')));
                                } else {
                                    echo json_encode(array('status' => 1, 'message' => '顺利通关', 'result' => array('type' => $type, 'isFinal' => false)));
                                }
                            }
                        } elseif ($type == 1) {
                            $missionInfo = (array)json_decode($team->missionInfo, true);
                            if (array_key_exists($lineId . '-' . $siteId, $missionInfo)) {
                                $missionInfoTitle = $missionInfo[$lineId . '-' . $siteId]['title'];
                                $missionInfoUrl = $missionInfo[$lineId . '-' . $siteId]['url'];
                                echo json_encode(array('status' => 1, 'message' => '已领取任务', 'result' => array('type' => $type, 'title' => $missionInfoTitle, 'url' => $missionInfoUrl)));
                            } else {
                                //随机任务
                                $siteModel = new \Model\Site();
                                $where = array('siteId' => $siteId, 'lineId' => $lineId);
                                $site = $siteModel->find($where);
                                $siteMission = json_decode($site->mission, true);
                                $rendSiteMission = array_rand($siteMission);
                                //录入个人任务
                                $missionInfo[$lineId . '-' . $siteId] = array('title' => $rendSiteMission, 'url' => $siteMission[$rendSiteMission]);
                                $teamInfo = \Model\Team::find($team->id);
                                $param['missionInfo'] = json_encode($missionInfo);
                                $teamInfo->set($param);
                                $teamInfo->save();
                                echo json_encode(array('status' => 1, 'message' => '下面是任务', 'result' => array('type' => $type, 'title' => $rendSiteMission, 'url' => $siteMission[$rendSiteMission])));
                            }
                        }
                    } else {
                        echo json_encode(array('status' => 2, 'message' => '没有找到队伍'));
                    }
                }
            } else {
                echo json_encode(array('status' => 2, 'message' => '没有成员'));
            }
        }
    }

    public function post()
    {

    }
}

