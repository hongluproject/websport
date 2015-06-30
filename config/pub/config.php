<?php

/**
 * Database
 * This system uses PDO to connect to MySQL, SQLite, or PostgreSQL.
 * Visit http://us3.php.net/manual/en/pdo.drivers.php for more info.
 */
define('AVOS_PATH','https://leancloud.cn:443/1/classes/');
define('APP_ID','X-AVOSCloud-Application-Id:j3hcadoeln0qtw2b9ccc0tsyiwyxjj9k1qbixgzfjc7163fq');
define('App_KEY','X-AVOSCloud-Application-Key:7tsnockxq4jb2ff3ofacq9o4knsxcolldb4nq74o0z54kicc');
$config['domain'] =AVOS_PATH;

$config['database'] = array(
    'default' => array(
        'dns'      => "mysql:host=10.10.78.24;port=3306;dbname=sporthoopeng",
        'username' => 'root',
        'password' => 'Honglusahala2015',

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
