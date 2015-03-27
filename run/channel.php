<?php

ini_set('display_errors', 1);

error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if ($_SERVER['argv'][0]) {
    $br = "\n";
} else {
    $br = '<br>';
}

echo $br . 'CHANNEL BEGIN' . $br;

/**
 * 获取XML文件中的信息
 * Enter description here ...
 * @param string $path
 */
function getXMLInfo( $path ){

    try {

        $content = file_get_contents($path);
        if(!empty($content)){
            $xml = simplexml_load_string($content);
            return $xml;
        }else{
            return 'Can not get such file -->'.$path;
        }

    } catch (Exception $e) {

    }

}

/**
 * 获取一代直播频道id
 * @param $apiurl
 */
function getZhibo1IDs($apiurl,$channel_pre){

    $channel = getXMLInfo($apiurl);
    if ($channel) {
        $ids = array();
        foreach  ($channel->Channels->ch as $key=>$value) {
            foreach ($value->attributes() as $k=>$v) {
                if ($k=='id') {
                    //echo $k.'="'.$v."\"\n";
                    $ids[] = $channel_pre.$v;
                }
            }
        }
        return $ids;
    } else {
        return 'Can not get zhiboid from ---'.$apiurl;
    }

}

/**
 * 获取二代直播频道id
 * @param $apiurl
 * @param $channel_pre
 */
function getZhibo2IDs($apiurl,$channel_pre){

    $channel = getXMLInfo($apiurl);
    if ($channel) {
        $ids = array();
        foreach ($channel->items->item as $key=>$value) {
            foreach ($value->attributes() as $k=>$v) {
                if ($k=='id') {
                    //echo $k.'="'.$v."\"\n";
                    $ids[] = $channel_pre.$v;
                }
            }
        }
        return $ids;
    } else {
        return 'Can not get zhiboid from ---'.$apiurl;
    }

}

$time = date('Y-m-d H:i:s');

//包含config配置文件
$env = (get_cfg_var('pptv.env') ? get_cfg_var('pptv.env') : 'pub');
$realpath = dirname(__FILE__);
$pos = strpos($realpath, 'run',1);
$path = substr($realpath,0,$pos).'config/'.$env.'/config.php';
require($path);

// 接口url
$api = $config['useapi'];

// 频道前缀
$pre = $config['channelpre'];

// 获取直播频道id
$zhibo1ids = getZhibo1IDs($api['zhibo1'],$pre);
$zhibo2ids = getZhibo2IDs($api['zhibo2'],$pre);
if (!is_array($zhibo1ids)) {
    die($zhibo1ids.$br);
}
if (!is_array($zhibo2ids)) {
    die($zhibo2ids.$br);
}
$zhiboids = array_merge($zhibo1ids,$zhibo2ids);

if (!empty($zhiboids)) {

    //包含mysql操作类
    require('database.php');
    $table = 'dp_horn_channel';
    $db = new Database($config['database']['default']);
    $rs = $db->fetch('select channel_key from `'.$table.'`');

    //获得channel key array
    $channel_key = array();
    foreach ($rs as $key=>$value) {
        $channel_key[] = $value->channel_key;
    }

    foreach ($zhiboids as $key=>$value ) {
        if (!in_array($value,$channel_key)) {
            $stat = $db->insert($table,array('channel_key'=>$value,'create_time'=>$time));
            if ($stat) {
                echo "Add new channel [".$value."] to ".$table." success!".$br;
            } else {
                echo "Add new channel [".$value."] to ".$table." failure!".$br;
            }
        }
    }

} else {

    echo 'NO channel found';

}

echo $br."DONE".$br;

?>