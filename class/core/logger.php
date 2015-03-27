<?php
/**
 * 日志
 * @author corriezhao
 *
 */

namespace Core;

abstract class Logger
{
    protected $_messages = array();
    protected $_level = 0;
    protected $_sync = false;

    const LEVEL_DEBUG = 0;
    const LEVEL_NOTICE = 1;
    const LEVEL_WARN = 2;
    const LEVEL_ERROR = 3;
    const LEVEL_CRITICAL = 4;

    private static $levels = array(
        self::LEVEL_DEBUG    => 'debug',
        self::LEVEL_WARN     => 'warn',
        self::LEVEL_NOTICE   => 'notice',
        self::LEVEL_ERROR    => 'error',
        self::LEVEL_CRITICAL => 'critical',
    );

    /**
     * factroy a logger
     *
     * @param string $name
     * @return Logger
     */
    public static function factory($name = 'default')
    {
        if (!$config = Config::get('logger.' . $name))
        {
            throw new Exception('Config not exists for logger->' . $name);
        }
        $class = '\Core\Logger\\' . $config['driver'];
        return new $class($config);
    }

    /**
     * instance a logger
     *
     * @param string $name
     * @return Logger
     */
    public static function instance($name = 'default')
    {
        static $instance = array();
        if (!isset($instance[$name]))
        {
            $instance[$name] = self::factory($name);
        }
        return $instance[$name];
    }

    public function debug($msg)
    {
        $this->log($msg, self::LEVEL_DEBUG);
    }

    public function warn($msg)
    {
        $this->log($msg, self::LEVEL_WARN);
    }

    public function notice($msg)
    {
        $this->log($msg, self::LEVEL_NOTICE);
    }

    public function error($msg)
    {
        $this->log($msg, self::LEVEL_ERROR);
    }

    public function critical($msg)
    {
        $this->log($msg, self::LEVEL_CRITICAL);
    }

    public function log($msg, $level = self::LEVEL_NOTICE)
    {
        if ($level < $this->_level)
        {
            return;
        }
        $microtime = microtime(true);
        $message = array(
            'id'       => isset($_SERVER['HTTP_REQUEST_ID']) ? $_SERVER['HTTP_REQUEST_ID'] : '',
            'time'     => $microtime,
            'text'     => $msg,
            'level'    => self::$levels[$level],
            'ip'       => $_SERVER['REMOTE_ADDR'],
            'memory'   => memory_get_usage(),
            'datetime' => date('Y-m-d H:i:s', round($microtime)) . substr($microtime - floor($microtime), 1, 4),
            'date'     => date('Y-m-d', round($microtime)),
        );
        $this->_messages[] = $message;
        if ($this->_sync)
        {
            $this->write();
            unset($this->_messages);
        }
    }

    public function getMessages()
    {
        return $this->_messages;
    }

    abstract protected function write();

    function __destruct()
    {
        //析构时写入
        $this->write();
    }
}