<?php
namespace Controller\Front\Sport;

class Userinfo extends \Controller\Front
{

    protected $_tpl = 'front/sport/userinfo';

    public function get()
    {

        $result = \Model\Team::find(array('phone'=>$_GET['phone']));
        if($result->data){
            $teamName = $result->data['teamName'];
            $teamId = $result->data['teamId'];
        }

        $this->result = \Model\Member::fetch(array('teamId'=>$teamId));

    }

    public function post()
    {

    }
}

