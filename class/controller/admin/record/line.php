<?php

namespace Controller\Admin\Record;

class Line extends \Controller\Admin\Record
{
    public $data;
    public $path = array('record', 'record.line');
    protected $_tpl = 'admin/record/line';

    public function get()
    {
        $user = $this->user;
        //线路情况


        $siteModel = new \Model\Line();
        $where = array('lineManager' => $user->username);
        $this->lineInfo = $siteModel->find($where);

        //团队总数
        $db = \Model\Member::db();
        $this->teamNumber = $db->fetch('select count(*) as countNum from  `ma_team` where `lineId`='.$this->lineInfo->lineId);



        //已完成线路
        $this->hasFinish =  $db->fetch('select count(*) as countNum from  `ma_team` where `lineId`='.$this->lineInfo->lineId .' AND status =1 AND isFinish=1');




        //status=3
         $this->lineSignUp = $db->fetch('select count(*) as signUpNum,siteId  from  `ma_record` where `lineId`="'.$this->lineInfo->lineId .'" group by siteId');



        //取消成绩
        $this->CancelTeamNumber = $db->fetch('select count(*) as CancelCountNum from  `ma_team` where `lineId`="'.$this->lineInfo->lineId .'" AND status = 3');


        $teamSignUp = new \Model\Team();
        $where = array('lineId'=>$this->lineInfo->lineId,'status'=>1);
        $path = $this->getPath();
        $order = array('passSiteNum' => 'desc','useTime'=>'asc');
        $this->result = $teamSignUp->fetchAsPage($where, $_GET['page'], 10, $order, $path);



        /*
      //已签到
      $this->receiveTeamNumber = $db->fetch('select count(*) as receiveTeamNumber from  `ma_record` WHERE `lineSiteId`="'.$user->username.'"');
      $sign = new \Model\Record();
      $where = array('lineSiteId'=>$user->username);
      $path = $this->getPath();
      $order = array('SignUpTime' => 'desc');
      $this->result = $sign->fetchAsPage($where, $_GET['page'], 10, $order, $path);*/

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