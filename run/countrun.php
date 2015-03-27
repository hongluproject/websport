<?php
/**
 * Automaic bak horn list .
 */

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if ($_SERVER['argv'][0]) {
    $br = "\n";
} else {
    $br = '<br>';
}

echo $br . 'COUNT HORN BEGIN' . $br;

//包含config配置文件
$env = (get_cfg_var('pptv.env') ? get_cfg_var('pptv.env') : 'pub');
$realpath = dirname(__FILE__);
$pos = strpos($realpath, 'run',1);
$path = substr($realpath,0,$pos).'config/'.$env.'/config.php';
require($path);

//方式一 读写文件减轻数据库压力
function mkfile( $file_path, $content){
    $handle = fopen($file_path, "w+");
    $stat = fwrite($handle, $content);
    fclose($handle);
    return $stat;
}

/**
 * 写文件
 * @param $filepath
 * @param $ids
 * @param $content
 */
function createFile($filepath,$ids,$content){
    // 计数写入文件
    $env = (get_cfg_var('pptv.env') ? get_cfg_var('pptv.env') : 'pub');
    $realpath = dirname(__FILE__);
    $pos = strpos($realpath, 'run',1);
    $main_path = substr($realpath,0,$pos);
    $count_file_path = $main_path.$filepath.$ids.'.txt';
    $stat =  mkfile($count_file_path,$content);
    if ($stat) {
        echo date('Y-m-d H:i:s',time()).' -- | -- '."Make file [".$ids.".txt] count success!"."\n";
    } else {
        echo date('Y-m-d H:i:s',time()).' -- | -- '."Make file [".$ids.".txt] count failure!"."\n";
    }
}

//存储方式二 REDIS扛压
function bakToRedis( $redis, $key ,$data ){

    //if ($data) {
        $data = $redis->SetEx( $key,7200,$data);
        if ($data) {
            echo '['.date('Y-m-d H:i:s',time())."]----- Bak ".$key." to redis success!\n";
        } else {
            echo '['.date('Y-m-d H:i:s',time())."]----- Bak ".$key." to redis failure!\n";
        }
    //}

}

//包含mysql操作类
require('database.php');
$table = 'dp_horn_channel';
$db = new Database($config['database']['default']);
$rspb = $db->fetch('select distinct channel_key from `'.$table.'` ');

//根据频道获取频道下喇叭列表
$table = 'dp_horn';
$myrs = $rb = $rs = null;
$time = time();
$start_time = date('Y-m-d H:i:s',$time-60*10);
$end_time = date('Y-m-d H:i:s',$time);
foreach ($rspb as $key=>$value) {
    $rb = $db->fetch('select * from `'.$table.'` where `ids` = "'.$value->channel_key.'" and `pb_status` >= 0 and `create_time` >= "'.$start_time.'" and `create_time` <= "'.$end_time.'" order by `create_time` asc');
    $rs[$value->channel_key] = $rb;
}

//根据筛选出频道下喇叭ID
foreach ($rs as $key => $value) {
    foreach ($value as $k => $v) {
        $myrs[$key][$k] = $v->id;
        /*foreach ($v as $hk => $hv) {
            $myrs[$key][$k][$hk] = $hv;
        }*/
    }
}

//方式一 存储文件的路径
$filePath = $config['bakfile']['count'];

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

foreach ($myrs as $key=>$value) {
    $content = json_encode($myrs);
    //方式一 读写文件保存喇叭队列
    //createFile($filePath,$key,$content);
    //方式二 将喇叭队列同步到REDIS
    bakToRedis( $redis, $key.'_count', $content);
}

echo 'DONE' . $br;




