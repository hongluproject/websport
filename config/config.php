<?php
/**
 * Config
 * Core system configuration file
 *
 * @package        MicroMVC
 * @author         David Pennington
 * @copyright      (c) 2010 MicroMVC Framework
 * @license        http://micromvc.com/license
 ********************************** 80 Columns *********************************
 */

// Base site url - Not currently supported!
$config['site_url'] = '/';

// Enable debug mode?
$config['debug_mode'] = false;

// Tiemzone
$config['timezone'] = 'Asia/Shanghai';

// Load boostrap file?
$config['bootstrap'] = FALSE;

// Available translations (Array of Locales)
$config['languages'] = array('en');

// 定义域名
$config['domain'] = getenv('HTTP_HOST');

// Routes
//to delete
$config['routes'] = array(
    ''                        => '\Controller\Front\Page404',
    '404'                     => '\Controller\Front\Page404',

    //人员
    'admin/member/delete'     => '\Controller\Admin\Member\Delete',
    'admin/member/edit'     => '\Controller\Admin\Member\Edit',
    'admin/member'             => '\Controller\Admin\Member\Page',

    //报名
    'admin/line/delete'     => '\Controller\Admin\Line\Delete',
    'admin/line/edit'     => '\Controller\Admin\Line\Edit',
    'admin/line'             => '\Controller\Admin\Line\Page',


    //点
    'admin/site/delete'     => '\Controller\Admin\Site\Delete',
    'admin/site/edit'     => '\Controller\Admin\Site\Edit',
    'admin/site'             => '\Controller\Admin\Site\Page',


    //报名
    'admin/signup/delete'     => '\Controller\Admin\Signup\Delete',
    'admin/signup/edit'     => '\Controller\Admin\Signup\Edit',
    'admin/signup'             => '\Controller\Admin\Signup\Page',

    //团队
    'admin/team/delete'     => '\Controller\Admin\Team\Delete',
    'admin/team/edit'     => '\Controller\Admin\Team\Edit',
    'admin/team'             => '\Controller\Admin\Team\Page',
    //任务
    'admin/mission/delete'     => '\Controller\Admin\Mission\Delete',
    'admin/mission/edit'     => '\Controller\Admin\Mission\Edit',
    'admin/mission'             => '\Controller\Admin\Mission\Page',
    'admin/record/site'     => '\Controller\Admin\Record\Site',
    'admin/record/line'     => '\Controller\Admin\Record\line',
    'admin/record/power'     => '\Controller\Admin\Record\power',
    'admin/record'     => '\Controller\Admin\Record\Site',
    'api/sport/scan'       => '\Controller\Api\Sport\Scan',
    'api/sport/userinfo'       => '\Controller\Api\Sport\Userinfo',
    'api/sport/pathinfo'       => '\Controller\Api\Sport\Pathinfo',
    'api/sport/userinfo'       => '\Controller\Api\Sport\Pathinfo',
    'api/sport/scan'       => '\Controller\Api\Sport\Scan',
    'api/sport/userinfo'       => '\Controller\Api\Sport\Userinfo',
    'api/sport/pathinfo'       => '\Controller\Api\Sport\Pathinfo',
    'sport/userinfo'       => '\Controller\Front\Sport\Userinfo',
    'admin/session/login'     => '\Controller\Admin\Session\Login',
    'admin/session/logout'    => '\Controller\Admin\Session\Logout',
    'admin/user/quick'        => '\Controller\Admin\User\Quick',
    'admin/user/add'          => '\Controller\Admin\User\Add',
    'admin/user/page'         => '\Controller\Admin\User\Page',
    'admin/user/download'         => '\Controller\Admin\User\Download',
    'admin/user'              => '\Controller\Admin\User\Page',
    'admin'                   => '\Controller\Admin\Index',
);


/**
 * System Events
 */
$config['events'] = array(
    //'pre_controller'	=> 'Class::method',
    //'post_controller'	=> 'Class::method',
);

// Cas Auth config
$config['cas'] = array(
    'host'       => 'sso-cas.pplive.cn',
    'port'       => 8443,
    'context'    => '/cas',
    'real_hosts' => array(),
    'admin'      => array(
        'suaxu'
    )
);

/**
 * Cookie Handling
 * To insure your cookies are secure, please choose a long, random key!
 *
 * @link http://php.net/setcookie
 */
$config['cookie'] = array(
    'key'      => 'very-secret-key',
    'timeout'  => time() + (60 * 60 * 4), // Ignore submitted cookies older than 4 hours
    'expires'  => 0, // Expire on browser close
    'path'     => '/',
    'domain'   => '',
    'secure'   => '',
    'httponly' => '',
);

// Cache
$config['cache'] = array(
    'default'    => array(
        'driver'=> 'php',
        'hash'  => false,
        'dir'   => SP . 'storage/cache'
    ),
);


// PHP Bin
$config['php'] = array(
		'bin' => '/usr/bin/php'
);


$config['cas'] = array(
    'admin'      => array(
        'suaxu','fugang'
    )
);


/**
 * API Keys and Secrets
 * Insert you API keys and other secrets here.
 * Use for Akismet, ReCaptcha, Facebook, and more!
 */

//$config['XXX_api_key'] = '...';

// Env select and load.
$env = !empty($config['env']) ? $config['env'] : (get_cfg_var('pptv.env') ? get_cfg_var('pptv.env') : 'pub');
include($env . '/config.php');
unset($env);

return $config;