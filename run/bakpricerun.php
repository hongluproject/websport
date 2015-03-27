<?php
/**
 * Created by JetBrains PhpStorm.
 * User: frankfu
 * Date: 12-6-9
 * Time: 下午5:14
 * To change this template use File | Settings | File Templates.
 */

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if ($_SERVER['argv'][0]) {
    $br = "\n";
} else {
    $br = '<br>';
}

echo $br . 'BAK PRICE TO REDIS BEGIN' . $br;

//包含config配置文件
$env = (get_cfg_var('pptv.env') ? get_cfg_var('pptv.env') : 'pub');
$realpath = dirname(__FILE__);
$pos = strpos($realpath, 'run',1);
$path = substr($realpath,0,$pos).'config/'.$env.'/config.php';
require_once($path);

/**
 * curl 方法发送请求
 * Enter description here ...
 * @param unknown_type $url
 * @param unknown_type $data
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
    curl_setopt($curl, CURLOPT_TIMEOUT, 1);
    $cdata = curl_exec($curl);
    $cheaders = curl_getinfo($curl);
    echo '--'.$cheaders['http_code'].'--';
    if(200 == $cheaders['http_code']){
        return $cdata;
    }else{
        return 500;
    }
}

//包含REDIS类
if (!class_exists('Redis')){
    require_once('redis.php');
}
$redis=new Redis();
$redis->connect($config['redis']['default']['host'], $config['redis']['default']['port']);
if(!$redis->ping())
{
    die( "Cannot connect to redis server.\n" );
}

//获取价格
$api = $config['useapi'];
$data = curl($api['price'],'');

//同步信息到REDIS
if ($data) {
    //$redis->Del("prices");
    $data = $redis->SetEx( 'prices',7200,$data);
    if ($data) {
        echo '['.date('Y-m-d H:i:s',time())."]----- Bak price to redis success!";
    } else {
        echo '['.date('Y-m-d H:i:s',time())."]----- Bak price to redis failure!";
    }
}

echo $br . 'DONE' . $br;