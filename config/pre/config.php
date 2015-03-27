<?php

/**
 * Database
 * This system uses PDO to connect to MySQL, SQLite, or PostgreSQL.
 * Visit http://us3.php.net/manual/en/pdo.drivers.php for more info.
 */
$config['domain'] = 'horn.pptv.com';

$config['database'] = array(
    'default' => array(
        'dns'      => "mysql:host=masterdb.horn.idc.pplive.cn;port=3306;dbname=horn_server",
        'username' => 'pp_horn',
        'password' => 'A1L34sfe4eW3E4feNwI',
        'charset'  => 'utf8',
        'params'   => array()
    )
);

$config['redis'] = array(
    'default' => array(
        'host' => 'redis1.horn.idc.pplive.cn',
        'port' => '6386',
        'db'   => '1',
    )
);

$config['logger'] = array(
    'default' => array(
        'driver'     => 'file',
        'dir'        => '/home/logs/php',
        'filename'   => 'w2c.:level.log',
        'level'      => 3,
    ),
    'cli'     => array(
        'driver'     => 'file',
        'dir'        => '/home/logs/php',
        'filename'   => 'w2c.cli.log',
        'level'      => 3,
        'sync'       => true,
    ),
    'my' => array(
        'driver'   => 'file',
        'dir'      => '/home/logs/php',
        'filename' => date('Y-m-d').'-api.log',
        'level'    => 0,
    )
);

// PHP Api
$config['useapi'] = array(
    'price'=>'http://pppc.pptv.com/pricelist/bugle',
    'pay'=>'http://pppc.pptv.com/buyuseprop/bugle',
    'userPB'=>'http://pb.pptv.com/getmemberinfo',
    'pubComment'=>'http://p.comment.pptv.com/api/v1/comment.json',
    'zhibo1'=>'http://live.v2.pplive.com/interface/client2/clientlist.xml',
    'zhibo2'=>'http://live-cms.synacast.com/programms/api_all_channel',
);

//VIP md5 key
$config['md5key'] = array('pbkey'=>'fJasD890024t09A0f0ak','paykey'=>'sdag90jgq234tg24tmsdgl');

//Bak file
$config['bakfile'] = array('count'=> 'storage/horn/');

//open channel
$config['openchannel'] = true;

//channel prefer
$config['channelpre'] = 'pbar_video_';