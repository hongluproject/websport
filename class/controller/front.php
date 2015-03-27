<?php

namespace Controller;

abstract class Front extends \Core\Controller
{
    /**
     * @var \Core\View
     */
    public $content;


    // Global view template
    protected $_tpl;

    /**
     * Called after the controller is loaded, before the method
     *
     * @param string $method name
     */
    public function initialize($method)
    {
    }


    /**
     * Load database connection
     */
    public function load_database($name = 'default')
    {
        // Load database
        $db = new \Core\Database(config('database.' . $name));

        // Set default ORM database connection
        if (empty(\Core\ORM::$db))
        {
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
    public function showError($string, $url = false)
    {
        headers_sent() OR header('HTTP/1.0 404 Page Not Found');
        $this->nav = $this->menu = array();
        $this->content = new \Core\View('error');
        $this->content->set(array(
                'error'=> $string,
                'url'  => $url)
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

        if (!$this->content && $this->_tpl)
        {
            $this->content = new \Core\View($this->_tpl);
            $this->content->set(get_object_vars($this));
        }

        print $this->content;

        $layout = NULL;

        if (config('debug_mode'))
        {
            print new \Core\View('system/debug');
        }
    }

}

// End
