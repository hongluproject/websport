<?php
/**
 * Automaic redis .
 */
ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if ($_SERVER['argv'][0]) {
    $br = "\n";
} else {
    $br = '<br>';
}

echo $br . 'BAK HORN LIST TO REDIS BEGIN' . $br;
//服务器当前时间戳
$time = time();

//包含config配置文件
$env = (get_cfg_var('pptv.env') ? get_cfg_var('pptv.env') : 'pub');
$realpath = dirname(__FILE__);
$pos = strpos($realpath, 'run',1);
$path = substr($realpath,0,$pos).'config/'.$env.'/config.php';
require_once($path);

//包含mysql操作类
require('database.php');
$db = new Database($config['database']['default']);

// 获取配置信息
$table = 'dp_horn_conf';

/*
http://client.aplus.pptv.com/static_page/v33_user_panel/


http://client.aplus.pptv.com/static_page/v33_user_panel/



客户端3.3用户面板 	v33_user_panel*/

//获取喇叭处理个数配置
$hornnum = $db->fetch('select * from `'.$table.'` where `key` = "hornnum"');
if (!$hornnum) {
    echo "Can not get hounnum config!";exit;
}
//每次最多处理几条喇叭
$num = $hornnum[0]->status;
//获取喇叭播放时间配置
$horntime = $db->fetch('select * from `'.$table.'` where `key` = "horntime"');
if (!$horntime) {
    echo "Can not get hountime config!";exit;
}
//每条喇叭播放时间
$space = $horntime[0]->status;

//已发布喇叭表
$table = 'dp_horn';

/**
 * 获取某时段已发布喇叭
 * @param $db
 * @param $ids
 * @param $start_time
 * @param $end_time
 * @param int $num
 * @return array
 */
function getRsByTime( $db, $ids, $start, $num=2, $status = 3){
    $myrs = $child = $parent = array();
    $rb = $db->fetch('select * from `dp_horn` where `ids` = "'.$ids.'" and `pb_status` = 2  order by `create_time` asc limit '.$num*$start.','.$num);//and `modify_time` > "'.$start_time.'" and `modify_time` < "'.$end_time.'"
    if ($rb) {
        $pbody = $cbody = '';
        foreach ($rb as $k=>$v) {
            if ($v->pid) {
                $myparent = $db->fetch('select * from `dp_horn` where `pbid` = "'.$v->pid.'"');
                if ($myparent) {
                    foreach ($myparent[0] as $mk=>$mv) {
                        if ($mk == 'body') {
                            $params =  json_decode($mv);
                            //为了因双斜杠导致jsondecode无法正常解析json数组
                            foreach ($params as $pk=>$pv) {
                                    $pbody[$pk] = $pv;
                            }
                            $parent[$mk] = $pbody;
                        } else {
                            $parent[$mk] = $mv;
                        }
                    }
                }
            }
            if (empty($parent)) $parent = new \stdClass();
            foreach ($v as $vk=>$vv) {
                if ($vk == 'body') {
                    $params =  json_decode($vv);
                    //为了因双斜杠导致jsondecode无法正常解析json数组
                    foreach ($params as $pk=>$pv) {
                            $cbody[$pk] = $pv;
                    }
                    $child[$vk] = $cbody;
                } else {
                    $child[$vk] = $vv;
                }
            }

            $myrs[$k] = array('parent'=>$parent,'child'=>$child);
            if ($status == 3) {
                $stat = $db->update('dp_horn',array('pb_status'=>$status),array('id ='.$v->id));
            }

        }
    }
    return $myrs;
}
// 获取时间
//$now_start = 0;
//$next_start = 1;
//$start_time = date('Y-m-d H:i:s',$now-$num*$time*2);
//$end_time = date('Y-m-d H:i:s',$now);
//$open = $config['openchannel'];
// 获取所有频道id
$idsrs = $db->fetch('select distinct channel_key, status from `dp_horn_channel`'); //print_r($idsrs);exit;
$myparams = array();
// 根据频道获取频道该时段以发布的喇叭
foreach ($idsrs as $key=>$value) {
    echo '['.$value->channel_key.']';
    $now = getRsByTime($db,$value->channel_key,0,$num,3);
    $next = getRsByTime($db,$value->channel_key,0,$num,2);
    $params = array('status'=>true,'data'=>array('open'=>($value->status)?true:false,'refresh'=>$num*$space,'showtime'=>$space*1,'now'=>$now ,'next'=>$next));
    $myparams[$value->channel_key] = $params;
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

//将不同频道已发布喇叭列表信息同步到REDIS
echo $br;
if ($myparams) {
    $stat = $redis->SetEx( 'allmy_horn_list', 7200, json_encode(str_replace(array('\"','"{','}"'),array('"','{','}'),$myparams)));
    if ($stat) {
        echo date('Y-m-d H:i:s',$time)."---Bak all channel horn to redis success!".$br;
    } else {
        echo date('Y-m-d H:i:s',$time)."---Bak all channel horn to redis failure!".$br;
    }
} else {
    echo date('Y-m-d H:i:s',$time)."---Can not find data bak to redis!".$br;
}

/*
foreach ($myparams as $key=>$value) {
    echo 'REFRESH '.$key.' DATA TO REDIS'.$br;
    $stat = $redis->Set( $key, json_encode($value));
}


// 根据频道发布本阶段喇叭
$parent = $myrs = $rb = $rs = null;
$myrs = array('parent'=>'','child'=>'');
foreach ($idsrs as $key=>$value) {
    //$rb = $db->fetch('select * from `'.$table.'` where `ids` = '.$value->ids.' and `pb_status` = 2 and `create_time` > "'.$starttime.'" and `create_time` < "'.$endtime.'" order by `create_time` asc limit '.$num);
    $rb = $db->fetch('select * from `'.$table.'` where `ids` = '.$value->ids.' and `pb_status` = 2 order by `create_time` asc limit '.$num);
    if ($rb) {
        foreach ($rb as $v=>$v) {
            if (!empty($v->pid)) {
                $parent = $db->fetch('select * from `'.$table.'` where `pbid` = '.$v->pid);
        }
            $myrs = array('parent'=>$parent,'child'=>$v);
        }
    }
    $rs[$value->ids] = $myrs;
}

$params = array('status'=>true,'data'=>array('open'=>true,'refresh'=>$num*$time,'showtime'=>$time,'now'=>$now ,'next'=>$next));

//包含redis操作类
require('redis.php');
$redis = new Redis( $config['redis']['default']['host'], $config['redis']['default']['port']);
foreach ($rs as $key=>$value) {
    $stat = $redis->Set( $key, json_encode($value));
}
*/
echo 'DONE' . $br;