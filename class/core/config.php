<?php
/**
 * Config
 *
 * @author Corrie Zhao <hfcorriez@gmail.com>
 */

namespace Core;

class Config
{
    public static $config = array();

    /**
     * init config
     *
     * @param array $config        values
     */
    public static function setup($config)
    {
        self::$config = $config;
    }

    /**
     * Get config
     *
     * @param string $key
     */
    public static function get($key = false, $default = null)
    {
        $tmp = $default;
        if (strpos($key, '.') !== false)
        {
            $ks = explode('.', $key);
            $tmp = &self::$config;
            foreach ($ks as $k)
            {
                if (!array_key_exists($k, $tmp)) return $default;

                $tmp = & $tmp[$k];
            }
        }
        else
        {
            if (isset(self::$config[$key]))
            {
                $tmp = self::$config[$key];
            }
        }
        return $tmp;
    }

    /**
     * Set config
     *
     * @param string $key
     * @param mixed  $value
     */
    public static function set($key, $value)
    {
        if (strpos($key, '.') !== false)
        {
            $ks = explode('.', $key);
            $tmp = & self::$config;
            foreach ($ks as $k)
            {
                if (!is_array($tmp)) return false;
                if (!array_key_exists($k, $tmp)) $tmp[$k] = array();

                $tmp = & $tmp[$k];
            }
            $tmp = $value;
        }
        else
        {
            self::$config[$key] = $value;
        }
        return true;
    }
}