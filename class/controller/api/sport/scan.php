<?php
namespace Controller\Api\Sport;

class Scan extends \Controller\Api
{
    public function get()
    {
        $siteId = $_GET['siteId'];
        $lineId = $_GET['lineId'];
        $phone = $_GET['phone'];
        $type = $_GET['type'];
        if (!$type) {
            echo json_encode(array('status' => 2, 'message' => '没有type'));
            exit;
        } else if (!$phone) {
            echo json_encode(array('status' => 2, 'message' => '没有注册号'));
        } else {
            $memberModel = new \Model\Member();
            $where = array('phone' => $phone);
            $member = $memberModel->fetch($where, 1);
            if ($member) {
                $teamId = $member[0]->teamId;
                if ($teamId) {
                    $teamModel = new \Model\Team();
                    $where = array('teamId' => $teamId);
                    $team = $teamModel->fetch($where, 1);
                    //找到team
                    if ($team) {
                        if ($type == 2) {
                            $passInfo =(array)json_decode($team[0]->pathInfo,true);
                            if (array_key_exists($lineId.'-'.$siteId, $passInfo)) {

                                if ($siteId != 8) {
                                    echo json_encode(array('status' => 1, 'message' => '已经扫描过关卡', 'result' => array('type' => $type, 'isFinal' => false)));
                                } else {
                                    echo json_encode(array('status' => 1, 'message' => '已经扫描过关卡', 'result' => array('type' => $type, 'isFinal' => true, 'passurl' => 'http://www.baidu.com')));
                                }
                            } else {
                                $passInfo[$lineId.'-'.$siteId] = array('memberStatus' => 1, 'passTime' => date('Y-m-d H:i:s'));
                                $teamInfo = \Model\Team::find($team[0]->id);
                                $param['pathInfo']= json_encode($passInfo);
                                $teamInfo->set($param);
                                $teamInfo->save();
                                if ($siteId != 8) {
                                    echo json_encode(array('status' => 1, 'message' => '顺利通关', 'result' => array('type' => $type, 'isFinal' => false)));
                                } else {
                                    echo json_encode(array('status' => 1, 'message' => '顺利通关', 'result' => array('type' => $type, 'isFinal' => true, 'passurl' => 'http://www.baidu.com')));
                                }
                             }
                        } elseif ($type == 1) {
                            //todo insert db
                            echo json_encode(array('status' => 1, 'message' => '下面是任务', 'result' => array('type' => $type, 'title' => '任务描述。这个你这次跳楼一百次', 'url' => 'http://www.baidu.com')));
                        }

                    } else {
                        echo 'no team find';
                    }
                }
            } else {
                echo "no member find";
            }

        }
    }

    public function post()
    {

    }
}

