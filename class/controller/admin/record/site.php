<?php

namespace Controller\Admin\Record;

class Site extends \Controller\Admin\Record
{
    public $data;
    public $path = array('record', 'record.site');
    protected $_tpl = 'admin/record/site';

    public function get()
    {
        $user = $this->user;
        //线路情况
        $siteModel = new \Model\Site();
        $where = array('siteManager' => $user->username);
        $this->siteInfo = $siteModel->find($where);

        //团队总数
        $db = \Model\Member::db();
        $this->teamNumber = $db->fetch('select count(*) as countNum from  `ma_team` where `lineId`='.$this->siteInfo->lineId);

        //取消成绩
        $this->CancelTeamNumber = $db->fetch('select count(*) as CancelCountNum from  `ma_team` where `lineId`="'.$this->siteInfo->lineId .'" AND status = 3');
        //应到  减
        //已签到
        $this->receiveTeamNumber = $db->fetch('select count(*) as receiveTeamNumber from  `ma_record` WHERE `lineSiteId`="'.$user->username.'"');
        $sign = new \Model\Record();
        $where = array('lineSiteId'=>$user->username);
        $path = $this->getPath();
        $order = array('SignUpTime' => 'desc');
        $this->result = $sign->fetchAsPage($where, $_GET['page'], 10, $order, $path);




        if($this->siteInfo->siteId == 0){
            $this->PreReceiveTeamNumber  = 0;
        }else{
            $preSiteId =$this->siteInfo->lineId.'-'.($this->siteInfo->siteId-1);
             $this->PreReceiveTeamNumber = $db->fetch('select count(*) as PreReceiveTeamNumber from  `ma_record` WHERE `lineSiteId`="'.$preSiteId.'"');
        }

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