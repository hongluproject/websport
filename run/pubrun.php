<?php
/**
 * Automaic publish horn .
 */

ini_set('display_errors', 1);
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

if ($_SERVER['argv'][0]) {
    $br = "\n";
} else {
    $br = '<br>';
}

echo $br . 'PUBLISH HORN BEGIN' . $br;

/**
 * curl 方法发送请求
 * Enter description here ...
 * @param string $url
 * @param string $params
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
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    $cdata = curl_exec($curl);
    $cheaders = curl_getinfo($curl);

    /*写日志*/
    echo "[url] => ".$cheaders['url']."\n";
    echo "[http_code] => ".$cheaders['http_code']."\n";
    echo "[header_size] => ".$cheaders['header_size']."\n";
    echo "[request_size] => ".$cheaders['request_size']."\n";
    echo "[filetime] => ".$cheaders['filetime']."\n";
    echo "[ssl_verify_result] => ".$cheaders['ssl_verify_result']."\n";
    echo "[redirect_count] => ".$cheaders['redirect_count']."\n";
    echo "[total_time] => ".$cheaders['total_time']."\n";
    echo "[namelookup_time] => ".$cheaders['namelookup_time']."\n";
    echo "[connect_time] => ".$cheaders['connect_time']."\n";
    echo "[pretransfer_time] => ".$cheaders['pretransfer_time']."\n";
    echo "[size_upload] => ".$cheaders['size_upload']."\n";
    echo "[size_download] => ".$cheaders['size_download']."\n";
    echo "[speed_download] => ".$cheaders['speed_download']."\n";
    echo "[speed_upload] => ".$cheaders['speed_upload']."\n";
    echo "[download_content_length] => ".$cheaders['download_content_length']."\n";
    echo "[starttransfer_time] => ".$cheaders['starttransfer_time']."\n";
    echo "[redirect_time] => ".$cheaders['redirect_time']."\n";
    echo "\n";

    if(isset($cheaders['http_code'])){
        if (200 == $cheaders['http_code']) {
            return $cdata;
        } else {
            return $cheaders['http_code'];
        }
    }else{
        return 600;
    }

}

//包含config配置文件
$env = (get_cfg_var('pptv.env') ? get_cfg_var('pptv.env') : 'pub');
$realpath = dirname(__FILE__);
$pos = strpos($realpath, 'run',1);
$path = substr($realpath,0,$pos).'config/'.$env.'/config.php';
require($path);

//包含mysql操作类
require('database.php');
$table = 'dp_horn';
$db = new Database($config['database']['default']);
$rs = $db->fetch('select * from `'.$table.'` where `pb_status` = 1 order by `create_time` asc limit 2');

if ($rs) {

    //引入加密通用类
    require('crypt.php');
    $crypt = new Crypt();
    //包含redis操作类
    //require('redis.php');
    //$redis = new Redis( $config['redis']['default']['host'], $config['redis']['default']['port']);
    //接口信息获取
    $api = $config['useapi'];
    $md5key = $config['md5key'];

    //获取用户喇叭价格
    //$prices = $redis->Get('prices');
    //$prices = json_decode($prices);
    //通过接口获取价格
    $stat = curl($api['price'],array());

    if (is_numeric($stat)) {

        echo "Can not get horn price!---[VIP price error code:".$stat."]".$br;

    } else {

        $prices = json_decode($stat);

        //支付PB发布喇叭
        $myparams = $params = $price = $number = $ustr = $usertype = $time =null;
        foreach ($rs as $key=>$value) {
            // 判断喇叭信息是否为空
            //$str = str_replace("\\","$|$",$value->body);
            $params =  json_decode($value->body);
            //为了因双斜杠导致jsondecode无法正常解析json数组
            foreach ($params as $k=>$v) {

                    $myparams[$k] = $v;

            }

            if ( !isset($myparams['txt']) || empty($myparams['txt']) ) {

                $stat = $db->update($table,array('pb_status'=>'-1'),array('id ='.$value->id));

                echo "Empty horn info can not be show!".$br;

            } else {

                echo "[HORN-ID:".$value->id."]".$br.$br;

                //3des加密key
                $index = rand(1, 10);
                //3DES加密用户名
                $ustr = $crypt::encrypt('passport',$myparams['username'],$index);
                //用户类型
                $usertype = $myparams['vip'];

                foreach ($prices as $pkey=>$item) {
                    if ($item->usertype == $usertype) {
                        //喇叭价格
                        $price = $item->promoteprice;
                        //喇叭数量
                        $number = $item->number;
                        break;
                    }
                }
                //单个喇叭价格
                $pbs = number_format($price/$number, 2, '.', '0');
                //喇叭数量
                $number = 1;
                //时间戳
                $time = time();
                //md5加密串
                $md5 = md5($ustr.$usertype.$number.$pbs.$time.$md5key['paykey']);
                //echo $ustr."|".$usertype."|".$number.'__'.$pbs.'__'.$time.'&&&'.$md5key['paykey'].'|||||';
                $post = array('ustr'=>$ustr,'usertype'=>$usertype,'number'=>$number,'pbs'=>$pbs,'time'=>$time,'index'=>$index,'md5'=>$md5);
                //pb支付接口请求
                $stat = curl($api['pay'],http_build_query($post));

                if (is_numeric($stat)) {
                    echo "Vip server pay api busy!---[VIP pay error code:".$stat."]".$br;
                } else {
                    $stat = json_decode($stat);
                    if ($stat->errcode) {
                        echo $stat->msg."---[VIP pay error code:".$stat->errcode."]".$br;
                        //未付款成功将喇叭状态改为失效
                        $stat = $db->update($table,array('pb_status'=>'-2'),array('id ='.$value->id));
                    } else {
                        //同步到pbar评论
                        if (empty($myparams['txt'])) {
                            //付款成功但是因喇叭内容为空,喇叭无法同步到pbar修改喇叭状态
                            $stat = $db->update($table,array('pb_status'=>'-3'),array('id ='.$value->id));
                        } else {

                            //同步pbar评论
                            $stat = curl($api['pubComment'],urldecode(http_build_query($myparams)));
                            //echo $api['pubComment'].'?'.urldecode(http_build_query($myparams));//print_r($stat);
                            if (is_numeric($stat)) {
                                echo "Pbar comment api busy!---[Pbar error code:".$stat."]".$br;
                                //喇叭无法同步到pbar修改喇叭状态
                                //$stat = $db->update($table,array('pb_status'=>'-3'),array('id ='.$value->id));
                                $stat = $db->update($table,array('pb_status'=>'2'),array('id ='.$value->id));
                            } else {
                                //获取pbar返回信息
                                $pbrs = json_decode(substr($stat,1,-1));
                                if (isset($pbrs->result)) {
                                    //pbar对应ID
                                    $cid = $pbrs->cid[0];
                                    $stat = $db->update($table,array('pbid'=>$cid,'pb_status'=>'2'),array('id ='.$value->id));
                                    if ($stat) {
                                        echo date('Y-m-d H:i;s',$time)."---|---Publish horn [".$value->id."] success!".$br;
                                        //$db->insert();
                                    } else {
                                        echo "Horn pay success,update pb_status failure!".$br;
                                    }
                                } else {
                                    echo "P bar comment api busy!---[Pbar error code:".$stat."]".$br;
                                    //喇叭无法同步到pbar修改喇叭状态
                                    //$stat = $db->update($table,array('pb_status'=>'-3'),array('id ='.$value->id));
                                    $stat = $db->update($table,array('pb_status'=>'2'),array('id ='.$value->id));
                                }
                            }

                        }

                    }
                }

            }

        }

    }

}


echo 'DONE' . $br;
