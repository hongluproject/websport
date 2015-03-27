<?php

/**
 * Database
 * This system uses PDO to connect to MySQL, SQLite, or PostgreSQL.
 * Visit http://us3.php.net/manual/en/pdo.drivers.php for more info.
 */

// Enable debug mode?
$config['debug_mode'] = true;
/**
 * Database
 * This system uses PDO to connect to MySQL, SQLite, or PostgreSQL.
 * Visit http://us3.php.net/manual/en/pdo.drivers.php for more info.
 */
define('AVOS_PATH','https://leancloud.cn:443/1/classes/');
define('APP_ID','X-AVOSCloud-Application-Id:bwc6za4i2iq5m7kxbqmi6h31sp21wjcs2zxsns15q9tbqthq');
define('App_KEY','X-AVOSCloud-Application-Key:md7jbe3xso3061p2lnj75puu1s87494nw7al00ctu5i8ib1z');



$config['domain'] =AVOS_PATH;

$config['database'] = array(
    'default' => array(
        'dns'      => "mysql:host=127.0.0.1;port=3306;dbname=hoopeng",
        'username' => 'root',
        'password' => '',
        'charset'  => 'utf8',
        'params'   => array()
    )
);


$config['pingKey']   =  'sk_live_q1aX98rz9ev1af9GKGb5W90K';
$config['pingAppId'] =  'app_e18iHKa1KyPKa584';

// PHP Api
$config['restapi'] = array(
    'news'=>AVOS_PATH,

);

$config['php'] = array(
    'bin' => '/usr/bin/php'
);


$config['redis'] = array(
    'default' => array(
        'host' => '115.182.194.32',
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



