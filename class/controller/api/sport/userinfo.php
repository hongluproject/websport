<?php
namespace Controller\Api\Sport;

class Userinfo extends \Controller\Api
{
    public function get()
    {
        if($_GET['format'] == 2){
            $memberModel = new \Model\Member();
            $members = $memberModel->fetch(array());
            $apiMembers = array();
            foreach ($members as $key=>$item){
                if($item->phone =='')
                    continue;
                if(substr($item->userId,-1) == 1){
                    $type = 'leader';
                }else{
                    $type = 'members';
                }

                $apiMembers[$item->teamId][$type][] = array('phone'=>$item->phone,'username'=>$item->username,'teamName'=>$item->teamName);

/*
                $apiMembers[$item->teamId][$type]['phone'][] = $item->phone;
                $apiMembers[$item->teamId][$type]['username'][] = $item->username;*/
            }
             echo json_encode($apiMembers);

        }else{
            $memberModel = new \Model\Member();
            $members = $memberModel->fetch(array());
            $apiMembers = array();
            foreach ($members as $key=>$item){
                $apiMembers[$key]['phone'] = $item->phone;
                $apiMembers[$key]['username'] = $item->username;
            }
            echo json_encode($apiMembers);
        }

    }

    public function post()
    {
    }
}

