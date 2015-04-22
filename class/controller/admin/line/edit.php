<?php

namespace Controller\Admin\Line;
class Edit extends \Controller\Admin\Line
{
    public $data;
    public $path = array('line', 'line.edit');
    protected $_tpl = 'admin/line/edit';
    public function get($id)
    {
        if ($id) {
            $this->result = \Model\Line::find($id);
        } else {
            $this->result = array();
        }
    }

    public function post($id)
    {
        $data = $_POST;

        $user = $this->user;
        if($user->admin!=1&&$user->username !=$_POST['lineId']){
            echo "cannot edit other line";exit;
        }
        $data['lineManager'] = $lineManager = $_POST['lineId'];
        $user = \Model\User::find(array('username' => $lineManager));
        if(empty($user)){
            $user = new \Model\User();
            $userName =  $lineManager;
            $userPassword = substr(md5($lineManager),0,6);
            $param['username'] = $userName;
            $param['password'] = md5($userPassword);
            $param['level'] = 1;
            $param['status'] = 1;
            $user->set($param);
            $user->save();
        }

        $data['lineId'] = trim($data['lineId']);
        if ($id) {
            $line = \Model\Line::find($id);
            $line->set($data);
            $line->save();
        } else {
            $line = new \Model\Line();
            $line->set($data);
            $line->save();
        }
        redirect('/admin/line');
    }
}