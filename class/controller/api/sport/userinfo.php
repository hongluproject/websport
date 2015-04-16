<?php
namespace Controller\Api\Sport;

class Userinfo extends \Controller\Api
{
    public function get()
    {
        $memberModel = new \Model\Member();
        $members = $memberModel->fetch(array());

        $apiMembers = array();
        foreach ($members as $key=>$item){
            $apiMembers[$key]['phone'] = $item->phone;
            $apiMembers[$key]['username'] = $item->username;
        }

        echo json_encode($apiMembers);


    }

    public function post()
    {
    }
}

