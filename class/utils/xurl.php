<?php

/**
 * xurl.php
 * 强大的URL获取类（支持post、timeout、useragent、http_version、proxy、header）
 *
 * @author      hfcorriez <hfcorriez@gmail.com>
 * @version     $Id: xurl.php v 0.1 2010-11-13 13:23:51 hfcorriez $
 * @copyright   Copyright (c) 2007-2010 PPLive Inc.
 *
 */
namespace Utils;

define('XURL_TYPE_FSOCK', 'fsock');
define('XURL_TYPE_SOCKET', 'socket');
define('XURL_TYPE_CURL', 'curl');
define('XURL_HTTP_VERSION_1_0', 1);
define('XURL_HTTP_VERSION_1_1', 2);

class XUrl {

    private $proxy;
    private $type = XURL_TYPE_FSOCK;
    private $post;
    private $timeout = 0;
    private $useragent;
    private $http_version = XURL_HTTP_VERSION_1_1;
    private $header = array();
    private $result = array('handle' => null, 'header' => null, 'content' => null, 'error' => null);

    /**
     * 设置代理（目前仅支持http代理）
     * @param string $str           支持ip:port方式
     */
    public function set_proxy($str) {
        list($this->proxy['host'], $this->proxy['port']) = explode(':', $str);
        return $this;
    }

    /**
     * 设置使用的请求类型，默认为fscok方式
     * @param string $type          0|1|2
     */
    public function set_type($type = XURL_TYPE_FSOCK) {
        $this->type = $type;
        return $this;
    }

    /**
     * 设置过期时间
     * @param int $sec              秒数
     */
    public function set_timeout($sec = 0) {
        $this->timeout = $sec;
        return $this;
    }

    /**
     * 设置header
     * @param mixed $name           header名称或者数组方式
     * @param string $value         header值
     */
    public function set_header($name, $value = '') {
        if (!$value) {
            if (is_array($name)) {
                foreach ($name as $k => $v) {
                    if (strpos($k, ':') !== false)
                        $this->header[] = $k;
                    elseif ($v)
                        $this->header[] = $k . ': ' . $v;
                }
            }elseif (strpos($name, ':') !== false) {
                $this->header[] = $name;
            }
        } else {
            $this->header[] = $name . ': ' . $value;
        }
        return $this;
    }

    /**
     * 设置HTTP协议版本号
     * @param string $ver           支持1.0,1.1
     */
    public function set_http_version($ver = XURL_HTTP_VERSION_1_1) {
        $this->http_version = $ver;
        return $this;
    }

    /**
     * 设置User-Agent
     * @param string $agent
     */
    public function set_useragent($agent) {
        $this->useragent = $agent;
        return $this;
    }

    /**
     * 设置POST数据
     */
    public function set_post($post) {
        if (is_array($post)) {
            $tmp = array();
            foreach ($post as $k => $v) {
                $tmp[] = "{$k}={$v}";
            }
            $post = join('&', $tmp);
        }
        $this->post = $post;
        return $this;
    }

    /**
     * 获取数据
     * @param string $url           要获取的URL
     */
    public function fetch($url) {
        $method = $this->type . '_request';
        $error = false;
        $this->check_url($url, $error);
        if ($error) {
            $result = $this->result;
            $result['error'] = $error;
            return $result;
        }
        $response = $this->$method($url);
        return $this->parse_response($response);
    }

    /**
     * 获取数据
     * @param string $url           要获取的URL
     */
    public function fetch_content($url) {
        $result = $this->request($url);
        return $result['content'];
    }

    /**
     * 获取头部信息
     * @param string $url           要获取的URL
     */
    public function fetch_header() {
        $result = $this->request($url);
        return $result['header'];
    }

    /**
     * 解析数据
     * @param string $response     要解析的数据
     */
    public function parse_response($response) {
        $result = $this->result;
        if ($response) {
            $pos = strpos($response, "\r\n\r\n");
            $head = substr($response, 0, $pos);
            $headers = explode("\r\n", $head);
            foreach ($headers as $k => $hline) {
                if ($k == 0) {
                    preg_match("/ (\d+) /", $hline, $match);
                    $http_info['_status_code'] = $match[1];
                    $http_info['_status_line'] = $hline;
                    continue;
                }
                list($key, $value) = explode(":", $hline);
                $http_info[strtolower(trim($key))] = trim($value);
            }
            $status = substr($head, 0, strpos($head, "\r\n"));
            $body = substr($response, $pos + 4);
            if (preg_match("/^HTTP\/\d\.\d\s(\d{3,4})\s/", $status, $matches)) {
                if (intval($matches [1]) / 100 == 2) {
                    $result['content'] = $body;
                } else {
                    $result['content'] = NULL;
                }
            } else {
                $result['content'] = false;
            }
            $result['header'] = $http_info;
        } else {
            $result = false;
        }
        return $result;
    }

    /**
     * 通过socket获取数据
     * @param string $url           要获取的URL
     */
    public function socket_request($url) {
        $response = false;
        $this->result['handle'] = 'socket';
        if (function_exists('socket_create')) {
            $u = $this->parse_url($url);
            if ($this->proxy) {
                $u['host'] = $this->proxy['host'];
                $u['port'] = $this->proxy['port'] ? $this->proxy['port'] : $u['port'];
            }
            $fsock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            if (!$fsock) {
                return false;
            }
            if ($this->timeout)
                stream_set_timeout($fsock, (int) $this->timeout);
            socket_set_nonblock($fsock);
            @socket_connect($fsock, $u['host'], $u['port']);
            $ret = socket_select($fd_read = array($fsock), $fd_write = array($fsock), $except = NULL, $fsock_timeout, 0);
            if ($ret != 1) {
                @socket_close($fsock);
                return false;
            }
            $in = $this->build_http_header($url);
            if (!@socket_write($fsock, $in, strlen($in))) {
                socket_close($fsock);
                return false;
            }
            unset($in);
            socket_set_block($fsock);
            @socket_set_option($fsock, SOL_SOCKET, SO_RCVTIMEO, array("sec" => $fsock_timeout, "usec" => 0));
            $response = '';
            while ($buff = socket_read($fsock, 1024)) {
                $response .= $buff;
            }
            @socket_close($fsock);
        }
        return $response;
    }

    /**
     * 通过curl获取数据
        * @param string $url           要获取的URL
            */
    public function curl_request($url) {
            $response = false;
        $this->result['handle'] = 'curl';
        if (function_exists("curl_init")) {
            $u = parse_url($url);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            if ($u['scheme'] == 'https') {
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
            }
            if ($this->useragent) {
                curl_setopt($ch, CURLOPT_USERAGENT, $this->useragent);
            }
            if ($this->http_version == XURL_HTTP_VERSION_1_0)
                curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
            if (!empty($this->proxy))
                curl_setopt($ch, CURLOPT_PROXY, "{$u['host']}:{$u['port']}");
            if ($this->timeout > 0)
                curl_setopt($ch, CURLOPT_TIMEOUT, (int) $this->timeout);
            $header_info = $this->header;
            if ($this->post) {
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->post);
                $header_info[] = 'Expect';
            }
            if ($header_info)
                curl_setopt($ch, CURLOPT_HTTPHEADER, $header_info);
            $response = curl_exec($ch);
            curl_close($ch);
        }
        return $response;
    }

    /**
     * 通过fsock获取数据
     * @param string $url           要获取的URL
     */
    public function fsock_request($url) {
        $this->result['handle'] = 'fsock';
        $response = false;
        $u = $this->parse_url($url);
        if ($this->proxy) {
            $u['host'] = $this->proxy['host'];
            $u['port'] = $this->proxy['port'] ? $this->proxy['port'] : $u['port'];
        }
        $fp = @fsockopen($u['host'], $u['port'], $null, $null, 1);
        if ($fp) {
            if ($this->timeout)
                stream_set_timeout($fp, (int) $this->timeout);
            $in = $this->build_http_header($url);
            if (fwrite($fp, $in)) {
                while ($line = fread($fp, 1024)) {
                    $response .= $line;
                }
                fclose($fp);
            }
        }
        return $response;
    }

    /**
     * 解析URL
     * @param string $url           要获取的URL
     */
    private function parse_url($url) {
        static $parses = array();
        if (empty($parses[$url])) {
            $u = parse_url($url);
            switch ($u['scheme']) {
                case 'http':
                    $default_port = '80';
                    break;
                case 'https':
                    $default_port = '443';
                    break;
                case 'ftp':
                    $default_port = '21';
                    break;
                case 'ftps':
                    $default_port = '990';
                    break;
                default:
                    $default_port = 0;
                    break;
            }
            $u['uri'] = ($u['path'] ? $u['path'] : '/') . ($u ["query"] != "" ? "?" . $u ["query"] : "") . (!empty($u ["fragment"]) ? "#" . $u ["fragment"] : "");
            unset($u['path'], $u['query'], $u['fragment']);
            $u['hostname'] = $u['host'] . (!empty($u['port']) ? ":{$u['port']}" : "");
            $u['host'] = @gethostbyname($u ["host"]);
            $u['port'] = !empty($u['port']) ? $u['port'] : $default_port;
            $parses[$url] = $u;
        }
        return $parses[$url];
    }

    /**
     * 检查URL
     * @param string $url           要获取的URL
     */
    private function check_url($url, &$error) {
        $u = $this->parse_url($url);
        if (!$u)
            $error = 'URL解析错误';
        if (in_array($u['port'], array('', 0)))
            $error = "访问端口异常{$u['port']}";
        if (!$u['host'])
            $error = "访问主机名异常:{$u['host']}";
        $error = false;
    }

    /**
     * 生成HTTP REQUEST HEADER
     * @param string $url           要获取的URL
     */
    private function build_http_header($url) {
        $u = $this->parse_url($url);

        $in = ($this->post ? 'POST ' : 'GET ') . $u['uri'] . " HTTP/" . $this->build_http_version() . "\r\n";
        $in .= "Accept: */*\r\n";
        $in .= 'Host: ' . $u ['hostname'] . "\r\n";
        if ($this->post) {
            //$in .= "Content-type: application/x-www-form-urlencoded\r\n";
            $in .= 'Content-Length: ' . strlen($this->post) . "\r\n";
        }
        if ($this->useragent)
            $in .= "User-Agent: {$this->useragent}\r\n";
        if ($this->header)
            $in .= join("\r\n", $this->header) . "\r\n";
        $in .= "Connection: Close\r\n\r\n";
        if ($this->post)
            $in .= $this->post . "\r\n\r\n";
        return $in;
    }

    /**
     * 生成HTTP版本号
     * @return string       协议版本号
     */
    private function build_http_version() {
        if ($this->http_version == XURL_HTTP_VERSION_1_0) {
            return '1.0';
        }
        return '1.1';
    }

}

?>