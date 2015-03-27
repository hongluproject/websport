<?php
/**
 * File Cache
 * @author Corrie Zhao <hfcorriez@gmail.com>
 *
 */
namespace Core\Cache;

class File extends \Core\Cache {
    private $dir;
    private $hash;

    public function __construct($config) {
        $this->dir = $config['dir'] . '/';
        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0777);
            chmod($this->dir, 0777);
        }
        $this->hash = isset($config['hash']) ? (boolean)$config['hash'] : true;
    }

    public function get($key) {
        if($this->hash === true){
            $cache_file = $this->dir . md5($key);
        } else {
            $cache_file = $this->dir . $key;
        }

        if (file_exists($cache_file)){
            $data = file_get_contents($cache_file) ;
            $expire = substr($data, 0, 10);

            if(time() < $expire){
                return unserialize(substr($data, 10));
            }else{
                unlink($cache_file);
            }
        }
    }

    public function set($key, $value, $expire = 0) {
        if($expire===0){
            $expire = time()+31536000;
        } else {
            $expire = time()+$expire;
        }

        if($this->hash === true){
            return file_put_contents($this->dir . md5($key) , $expire.serialize($value), LOCK_EX);
        }

        return file_put_contents($this->dir . $key , $expire.serialize($value), LOCK_EX);
    }

    public function delete($key) {
        if($this->hash === true){
            $cache_file = $this->dir.md5($key);
        } else {
            $cache_file = $this->dir.$key;
        }

        if (file_exists($cache_file)) {
            unlink($cache_file);
            return true;
        }
        return false;
    }
}