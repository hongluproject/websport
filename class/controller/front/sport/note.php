<?php
namespace Controller\Front\Sport;

class Note extends \Controller\Front
{

    protected $_tpl = 'front/sport/note';

    public function get()
    {
        $db = \Model\Member::db();
        $this->noteResult = $db->fetch('select * from sport_note order by count desc');
        $ip = $this->GetIP();
        $this->isNote = $db->fetch('select * from sport_record  where ip = "'.$ip.'"');


    }

    public function post()
    {
        header("Content-type: application/json");
        $status = array('status'=>1,'message'=>'OK');
        $ip =$this->GetIP();
        if($ip =="unknown"){
            $status['message'] ='不能重复投票';
            json_encode($status);exit;
        }
        $id= $_POST['id'];
        $db = \Model\Member::db();
        $this->searchResult = $db->fetch('select * from sport_record  where ip = "'.$ip.'" and objectId = "'.$id.'"');
        if(!$this->searchResult){
            $db = \Model\Line::db();
            $db->insert('sport_record',array('ip'=>$ip,'objectId'=>$_POST['id']));
            $sportNoteResult =  $db->fetch('select * from sport_note where objectId  = "'.$id.'"');
            $noteResultCount =  ++$sportNoteResult[0]->count;
            $noteResultId = $sportNoteResult[0]->id;
            $db->update('sport_note',array('count'=>$noteResultCount),array('id'=>$noteResultId));
            $status['status'] =2;
            $status['message'] ='投票成功';
        }else{
            $status['message'] ='不能重复投票';

        }
        echo  json_encode($status);exit;
    }


    function GetIP(){
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
            $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
            $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
            $ip = $_SERVER['REMOTE_ADDR'];
        else
            $ip = "unknown";
        return($ip);
    }
}




