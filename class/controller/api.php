<?php

namespace Controller;

//告诉浏览器此页面的过期时间(用格林威治时间表示)，只要是已经过去的日期即可。
header("Expires: Mon, 26 Jul 1970 05:00:00 GMT");
//告诉浏览器此页面的最后更新日期(用格林威治时间表示)也就是当天,目的就是强迫浏览器获取最新资料
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . "GMT");
//告诉客户端浏览器不使用缓存
header("Cache-Control: no-cache, must-revalidate");
//参数（与以前的服务器兼容）,即兼容HTTP1.0协议
header("Pragma: no-cache");
//输出MIME类型
header("Content-type: application/x-javascript");

abstract class Api extends \Core\Controller
{
    public $data = array();

    protected $format = 'json';
    protected $callback = '';
    protected $cb = '';

    protected $_redis;
    protected $_tpls = array();
    protected $_header_expires = 300;
    protected $_required = array();


    /**
     * Called after the controller is loaded, before the method
     *
     * @param string $method name
     */
    public function initialize($method)
    {
        if (!empty($_GET['format']) && in_array($_GET['format'], array('xml', 'json', 'jsonp')))
        {
            $this->format = $_GET['format'];
            if ($this->format == 'jsonp')
            {
                $this->callback = $_GET['callback'];
            }
        }

        foreach ($_GET as $key => $value)
        {
            // 只修改声明为null/string，可以访问的属性
            if ($key{0} != '_' && property_exists($this, $key) && in_array(gettype($this->{$key}), array('string',
                                                                                                         'NULL')) && !in_array($key, $this->getSolidProperty())
            )
            {
                $this->{$key} = $value;
            }
        }

        if ($this->cb && !$this->callback) $this->callback = $this->cb;

        foreach ($this->_required as $required)
        {
            if ($this->{$required} === null) $this->showError('Params error: ' . $required . ' is required.');
        }
    }

    /**
     * Save user session and render the final layout template
     */
    public function send()
    {
        if ($this->data === null)
        {
            $this->show404();
            return;
        }

        $tpl = !empty($this->_tpls[$this->format]) ? $this->_tpls[$this->format] : 'api/' . $this->format;
        $view = new \Core\View($tpl);
        $view->set(get_object_vars($this));

        if (headers_sent() || ob_get_length() > 0) $this->shutdown();

        header('Content-Type: application/' . ($this->format == 'jsonp' ? 'javascript' : $this->format) . '; charset=utf-8');

        if ($this->_header_expires > 0)
        {
            header('Pragma: public');
            header('Expires: ' . gmdate('D, d M Y H:i:s', time() + $this->_header_expires) . ' GMT');
            header("Cache-Control: public, max-age=$this->_header_expires");
        }
        else
        {
            header('Pragma: no-cache');
            header('Cache-Control: no-cache');
        }

        print $view;
    }

    // Cann't modified property.
    protected function getSolidProperty()
    {
        return array('content');
    }


    /**
     * Load database connection
     */
    protected function loadDatabase($name = 'default')
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
     * Show error message
     *
     * @param string $message
     */
    protected function showError($error)
    {
        unset($this->_tpls);
        headers_sent() OR header('HTTP/1.0 404 Not Found');
        $this->data = array('error'   => $error,
                            'request' => $_SERVER['REQUEST_URI']);
        $this->send();
        $this->shutdown();
    }


    /**
     * Show a 404 error page
     */
    protected function show404()
    {
        $this->showError('404 Not Found');
    }

    public function shutdown()
    {
        event('system.shutdown', $this);
        exit;
    }

    /**
     * 接口日志
     * @param $message
     */
    public function apilog( $message ){
        \Core\Logger::instance('my')->debug($message);
    }

    /**
     * unicode 转码
     * @param $str
     * @param string $code
     * @return string
     */
    public function unicodeToUTF8($str, $code = 'UTF-8') {
        $str = str_replace('\u', '%u', $str);
        $str = rawurldecode($str);
        preg_match_all("/(?:%u.{4})|.{4};|&amp;#\d+;|.+/U", $str, $r);
        $ar = $r[0];
        foreach ($ar as $k => $v) {
            if (substr($v, 0, 2) == "%u") {
                $ar[$k] = iconv("UCS-2BE", $code, pack("H4", substr($v, -4)));
            } elseif (substr($v, 0, 3) == "") {
                $ar[$k] = iconv("UCS-2BE", $code, pack("H4", substr($v, 3, -1)));
            } elseif (substr($v, 0, 2) == "&amp;#") {
                echo substr($v, 2, -1) . " ";
                $ar[$k] = iconv("UCS-2BE", $code, pack("n", substr($v, 2, -1)));
            }
        }
        return join("", $ar);
    }


    /**
     * 从UTF8转换成unicode beta1.0
     * @param mixed $string要转换的字符串,
     * @return unicode的十六进制编码
     */
    public function utf8_to_unicode_hex($string){
        $length = strlen($string);
        $outstring = "";
        for ( $i = 0; $i < $length; $i++ )  {
            $asc_value = ord($string[$i]);
            if($asc_value > 127) {
                if($asc_value >= 192 && $asc_value <= 223){
                    $str_dec = (ord($string[$i]) & 0x3f) << 6;
                    $i++;
                    $str_dec += ord($string[$i]) & 0x3f;
                    $str_hex = dechex($str_dec);
                    $outstring .= str_pad($str_hex,3,"0",STR_PAD_LEFT);
                }elseif($asc_value >= 224 && $asc_value <= 239){
                    $str_dec = (ord($string[$i]) & 0x1f) << 12;
                    $i++;
                    $str_dec += (ord($string[$i]) & 0x3f) << 6;
                    $i++;
                    $str_dec += ord($string[$i]) & 0x3f;
                    $outstring .=dechex($str_dec);
                }elseif($asc_value >= 240 && $asc_value <= 247){
                    $str_dec = (ord($string[$i]) & 0x0f) << 18;
                    $i++;
                    $str_dec += (ord($string[$i]) & 0x3f) << 12;
                    $i++;
                    $str_dec += (ord($string[$i]) & 0x3f) << 6;
                    $i++;
                    $str_dec += ord($string[$i]) & 0x3f;
                    $outstring .= dechex($str_dec);
                }else{
                    $str_hex = dechex(ord($string[$i]));
                    $outstring .= str_pad($str_hex,3,"0",STR_PAD_LEFT);
                }
            }else{
                $str_hex = dechex(ord($string[$i]));
                $outstring .= str_pad($str_hex,3,"0",STR_PAD_LEFT);
            }
        }
        return $outstring;
    }

    /**
     * 16进制转10进制
     * @param $uhStr
     * @return string
     */
    function unicodeHexToDec( $uhStr )
    {
        $gbStr = "";
        $uhArray = explode( "%u", substr($uhStr, 2));
        foreach( $uhArray as $udChar )
        {
            $udChar = hexdec( $udChar );
            $gbStr .= "&#".$udChar.";";
        }

        return $gbStr;
    }

}

// End
