<?php

/**
 * Database
 * This system uses PDO to connect to MySQL, SQLite, or PostgreSQL.
 * Visit http://us3.php.net/manual/en/pdo.drivers.php for more info.
 */
$config['database'] = array(
    'default' => array(
        'dns'      => "mysql:host=master.db;port=3306;dbname=pplive_cw",
        'username' => 'dev',
        'password' => 'dev!@#',
        'charset'  => 'utf8',
        'params'   => array()
    )
);

$config['redis'] = array(
    'default' => array(
        'host' => 'redis.db',
        'port' => '6379',
        'db'   => '1',
    )
);

$config['logger'] = array(
    'default' => array(
        'driver'     => 'file',
        'dir'        => SP . 'storage/log/',
        'filename'   => 'web.:date.log',
        'level'      => 1,
    ),
    'cli'     => array(
        'driver'     => 'file',
        'dir'        => SP . 'storage/log/',
        'filename'   => 'cli.:date.log',
        'level'      => 1,
        'sync'       => true,
    ),
    'my' => array(
        'driver'   => 'file',
        'dir'      => SP . 'storage/log/',
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