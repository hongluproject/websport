<?php
/**
 * Automaic create files .
 */

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if ($_SERVER['argv'][0]) {
	$br = "\n";
} else {
	$br = '<br>';
}

echo $br . 'PUBLISH HORN BEGIN' . $br;

$env = (get_cfg_var('pptv.env') ? get_cfg_var('pptv.env') : 'pub');
$realpath = dirname(__FILE__);
$pos = strpos($realpath, 'run',1);
$path = substr($realpath,0,$pos).'config/'.$env.'/config.php';
require_once($path);
print_r($config);exit;

//包含config配置文件
require('config.php');

//包含mysql操作类
require('database.php');

$table = 'dp_horn';

$db = new Database($config['database']['default']);

$rs = $db->fetch('select * from `'.$table.'` where `pb_status` = 1 order by `create_time` asc limit 2');
echo json_encode($rs);
/**
 * curl 方法发送请求
 * Enter description here ...
 * @param string $url
 * @param array $data
 */
function curl( $url, $params = '') {

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HEADER, 0);

    if (''!=$params) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
    }

    curl_setopt($curl, CURLOPT_URL, $url);
    $cdata = curl_exec($curl);
    $cheaders = curl_getinfo($curl);

    if(200 == $cheaders['http_code']){
        return $cdata;
    }else{
        return 500;
    }

}

$api = array(
    'price'=>'http://192.168.31.3:8080/pppc/pricelist/bugle',
    'pay'=>'http://192.168.31.3:8080/pppc/buyuseprop/bugle',
    'userPB'=>'http://pb.pptv.com/getmemberinfo',
    'pubComment'=>'http://p.comment.pptv.com/api/v1/comment.json/',
);

$md5key = 'fJasD890024t09A0f0ak';

if ($rs) {

    require('crypt.php');
    /*
    $index = rand(1, 10);
    $mm = Crypt::encrypt('passport','456',$index);
    echo $mm;
    echo $rs[0]->body;
    echo Crypt::decrypt( 'cookie',$mm).$br;
    exit;
    */

    //支付PB发布喇叭
    $params =  json_decode($rs[0]->body);
    $index = rand(1, 10);
    $ustr = Crypt::encrypt('passport',$params['Username'],$index);
    $usertype = $params['Vip'];
    $time = time();
    $md5 = md5($ustr.$usertype.$time.$md5key);
    $url = "" ;
    $post = array('ustr'=>$ustr,'usertype'=>$usertype,'time'=>$time,'md5'=>$md5);
    $stat = curl($api['pay'],$post);

    //将喇叭信息发布到P吧
    if ( 'ok'==$stat ) {
        $stat = curl($api['pubComment'],$params);
        if ($stat && isset($stat['result'])) {
            $cid = $stat['cid'];
            $stat = $db->update($table,array('cid'=>$cid,'pb_status'=>'2'),'id ='.$rs[0]->id);
            if ($stat) {
                echo "Horn publish success!".$br;
            } else {
                echo "Horn pay success,update pb_status failure!".$br;
            }
        } else {
            echo "P bar comment api busy！".$br;
        }
    } else {
        echo "Pay center api busy！".$br;
    }

}

echo $br . 'DONE' . $br;