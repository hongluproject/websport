<?php
namespace Controller;
error_reporting(0);

abstract class Admin extends \Core\Controller
{
    /**
     * @var \Core\View
     */
    public $content;
    /**
     * @var \Core\View
     */
    public $sidebar;

    /**
     * @var array Path
     */
    public $path = array('');

    // Navs
    public $nav = array(
        '' => array('首页', '/admin'),
        'member' => array('成员管理', '/admin/member'),
        'team' => array('队伍管理', '/admin/team'),
        'line' => array('线路管理', '/admin/line'),
/*        'signup' => array('报名管理', '/admin/signup'),*/
        'site' => array('站点管理', '/admin/site'),
/*        'mission' => array('任务管理', '/admin/mission'),*/
        'user' => array('用户管理', '/admin/user'),
    );

    // Sidebar Menus
    public $menu = array();

    // Validate
    public $validate = array();

    // User info;
    public $user;

    // Global view template
    protected $_layout = 'admin/layout';
    protected $_sidebar = 'admin/sidebar';
    protected $_tpl;
    protected $_login = true;

    /**
     * Called after the controller is loaded, before the method
     *
     * @param string $method name
     */
    public function initialize($method)
    {
        session_start();
        \Core\Session::start();
        $this->user = \Logic\User::getLogged();
        if ($this->_login && !$this->user) {
            $this->redirect("/admin/session/login");
        } elseif ($this->_login && $this->user && $this->user->status != 1) {
            $this->showError("您好 {$this->user->name}:<br/>未激活的帐号无法登陆，请联系管理员激活您的帐号：<i style='color:#85ff94;'>{$this->user->username}</i>！", false);
        }
    }


    /**
     * Load database connection
     */
    public function load_database($name = 'default')
    {
        // Load database
        $db = new \Core\Database(config('database.' . $name));
        // Set default ORM database connection
        if (empty(\Core\ORM::$db)) {
            \Core\ORM::$db = $db;
        }
        return $db;
    }


    /**
     * Show a 404 error page
     */
    public function show404()
    {
        headers_sent() OR header('HTTP/1.0 404 Page Not Found');
        $this->content = new \Core\View('404');
    }

    /**
     * Show a 404 error page
     */
    public function showError($string, $url = null)
    {
        headers_sent() OR header('HTTP/1.0 404 Page Not Found');
        $this->nav = $this->menu = array();
        $this->content = new \Core\View('error');
        $this->content->set(array(
                'error' => $string,
                'url' => $url)
        );
        $this->send();
        exit;
    }


    /**
     * Save user session and render the final layout template
     */
    public function send()
    {
        \Core\Session::save();
        headers_sent() OR header('Content-Type: text/html; charset=utf-8');
        if (!$this->content && $this->_tpl) {
            $this->content = new \Core\View($this->_tpl);
            $this->content->set(get_object_vars($this));
        }
        if (!$this->sidebar && $this->menu && $this->_sidebar) {
            $this->sidebar = new \Core\View($this->_sidebar);
            $this->sidebar->set(get_object_vars($this));
        }
        $layout = new \Core\View($this->_layout);
        $layout->set(get_object_vars($this));
        print $layout;
        $layout = NULL;
        if (config('debug_mode')) {
            print new \Core\View('system/debug');
        }
    }

    /**
     * 重定向
     * @param null $url
     */
    public function redirect($url = null)
    {
        //\Core\Session::save();
        if ($_REQUEST['forward']) {
            $url = $_REQUEST['forward'];
        }
        if (!$url) {
            $url = $_SERVER['HTTP_REFERER'];
        }
        redirect($url);
    }

}

// End
