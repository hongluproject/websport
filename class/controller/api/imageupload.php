<?php
namespace Controller\Api;
include(SP."class/utils/qiniu/io.php");
include(SP."class/utils/qiniu/rs.php");
class Imageupload extends \Controller\Api
{
    public function get()
    {

     }

    public function post(){
        $bucket = "hoopeng";
        $key = "tags/".date('YmdHis').rand(1,10000).'.jpg';
        $file = $_FILES['img']['tmp_name'];

        $domain = 'hoopeng.qiniudn.com';
        $accessKey = 'bGJ2PX1QjaSuy4Y9AaX-WgcKoGzIIFHXmVBqWHMt';
        $secretKey = '7PHdOXp912l54TYzG2P7Mmqw-AALLZ3Kaamv4885';
        Qiniu_SetKeys($accessKey, $secretKey);
        $putPolicy = new \Qiniu_RS_PutPolicy($bucket);
        $upToken = $putPolicy->Token(null);
        $putExtra = new \Qiniu_PutExtra();
        $putExtra->Crc32 = 1;
        $result = Qiniu_PutFile($upToken, $key, $file, $putExtra);
        $res["error"] = "";//错误信息
        $res["msg"] = "";//提示信息
        if(isset($result[0])){
            $res["error"] = 2;
            $res["msg"] = 'http://'.$domain. '/'.$result[0]['key'];
        }else{
            $res["error"] = 1;
            $res["msg"] = "there is a mistake";
        }
        echo json_encode($res);
        exit;
    }

}

