<?php
namespace Controller\Api\Sport;

class Userinfo extends \Controller\Api
{
    public function get()
    {
        $memberModel = new \Model\Member();
        $members = $memberModel->fetch(array());

        $apiMembers = array();
        foreach ($members as $item){
            $apiMembers[]['phone'] = $item->phone;
            $apiMembers[]['username'] = $item->username;
        }

        echo json_encode($apiMembers);


    }

    public function post()
    {
    }
}

