<?php

namespace Controller\Admin\Site;
class Edit extends \Controller\Admin\Site
{
    public $data;
    public $path = array('site', 'site.edit');

    protected $_tpl = 'admin/site/edit';

    public function get($id)
    {
        $db = \Model\Line::db();
        $table = 'ma_line';
        $this->lineList = $db->fetch('select * from  `ma_line` ');

        if ($id) {
            $this->result = \Model\Site::find($id);
        } else {
            $this->result = array();
        }
    }

    public function post($id)
    {

         try {


             $user = $this->user;
             if($user->admin!=1){
                 echo "cannot edit  site";exit;
             }
             $data = $_POST;
             $mission = array();
             if ($data['passInfo'] == 2) {
                 $mission = array_combine($_POST['missionTitle'], $_POST['missionUrl']);
             }

             /*$siteModel = new \Model\Site();
             $where = array('lineId' => $_POST['lineId']);
             $sites = $siteModel->fetch($where, 1000);
             $selfLine = array();
             foreach ($sites as $item) {
                 $selfLine[$item->siteId] = $item->siteId;
             }
             if (array_key_exists($_POST['siteId'], $selfLine)) {
                 echo "error line input";exit;
             }*/

             $data['mission'] = json_encode($mission);
             unset($data['missionTitle']);
             unset($data['missionUrl']);

             if ($data['passInfo'] == 2 && (empty($mission) || !$data['missionResult'])) {
                 echo "mission and mission result must be input";
                 exit;
             }


            if (!$data['position']) {
                echo "address  must be input";
                exit;
            }


            if ($data['section'] == 1 && $data['siteId'] != 0) {
                echo "select start position must start input be 0";
                exit;
            }

             list($userLine,$userSite) = explode('-',$this->user->username);
             if($this->user->admin!=1&&$this->user->username !=$_POST['lineId']&&$userLine!=$_POST['lineId']){
                 echo "cannot edit other line";exit;
             }

             if($this->user->level==2){
                 echo "cannot edit site info";exit;
             }


             $data['siteManager'] = $siteManager = $_POST['lineId'].'-'.$_POST['siteId'];
             $user = \Model\User::find(array('username' => $siteManager));
             if(empty($user)){
                    $user = new \Model\User();
                    $userName =  $siteManager;
                    $userPassword = substr(md5($siteManager),0,6);
                    $param['username'] = $userName;
                    $param['password'] = md5($userPassword);
                    $param['level'] = 2;
                    $param['status'] = 1;
                   $user->set($param);
                    $user->save();
             }

             $data['lineId'] = trim($data['lineId']);
             $data['siteId'] = trim($data['siteId']);
             if ($id) {
                $site = \Model\Site::find($id);
                $site->set($data);
                $site->save();
            } else {
                $site = new \Model\Site();
                $site->set($data);
                $site->save();
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            echo '</br>';
            echo '没有这个点标';
            exit;
        }
        redirect('/admin/site');
    }
}