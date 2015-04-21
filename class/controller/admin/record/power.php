<?php

namespace Controller\Admin\Record;

class Power extends \Controller\Admin\Record
{
    public $data;
    public $path = array('record', 'record.power');
    protected $_tpl = 'admin/record/power';

    public function get()
    {
        //团队总数
        $db = \Model\Member::db();
        $this->teamNumber = $db->fetch('select count(*) as countNum from  `ma_team`');
        //总弃权数
        $this->CancelTeamNumber = $db->fetch('select count(*) as CancelTeamNumber from  `ma_team` where status = 3');

        //各线路弃权总数
        $db = \Model\Member::db();
        $temp = $db->fetch('select `lineId`,count(*) as countNum from  `ma_team` where status =3 group by `lineId`');

        $dropGameTeamNum = array();
        foreach ($temp as $item) {
            $dropGameTeamNum[$item->lineId] = array('lineId' => $item->lineId, 'dropGameTeamNum' => $item->countNum);
        }


        //各线路应到人数   总数-status=3
        $temp = $db->fetch('select `lineId`,count(*) as countNum from  `ma_team` group by `lineId`');
        $shouldReceiveGameTeamNum = array();
        foreach ($temp as $item) {
            $shouldReceiveGameTeamNum[$item->lineId] = array('lineId' => $item->lineId, 'shouldReceiveGameTeamNum' => $item->countNum);
        }

        //各线路已完成人数
        $temp = $db->fetch('select `lineId`,count(*) as countNum from  `ma_team` where isFinish = 1 group by `lineId`');
        $finishGameTeamNum = array();
        foreach ($temp as $item) {
            $finishGameTeamNum[$item->lineId] = array('lineId' => $item->lineId, 'finishGameTeamNum' => $item->countNum);
        }

        foreach ($shouldReceiveGameTeamNum as $key=> $item) {
            $shouldReceiveGameTeamNum[$key]['dropGameTeamNum'] = $dropGameTeamNum[$key]['dropGameTeamNum']? $dropGameTeamNum[$key]['dropGameTeamNum']:0;
            $shouldReceiveGameTeamNum[$key]['finishGameTeamNum'] = $finishGameTeamNum[$key]['finishGameTeamNum']? $finishGameTeamNum[$key]['finishGameTeamNum']:0;
        }
        $this->result =  $shouldReceiveGameTeamNum;

    }


    public function getPath()
    {
        $page = (int)isset($_POST['page']) ? $_POST['page'] : 1;
        if ($page < 1) $page = 1;
        $query = $_POST;
        if (!empty($query)) {
            foreach ($query as $k => $v) {
                if (!$v) {
                    unset($query[$k]);
                    continue;
                }
                $query[$k] = urlencode($k) . "=" . urlencode($v);
            }
            $path = PATH . '?' . join('&', $query) . '&page=:page';
        } else {
            $path = PATH . '?' . 'page=:page';
        }
        return $path;
    }

}