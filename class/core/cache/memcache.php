<?php
/**
* MemCache
* @author Corrie Zhao <hfcorriez@gmail.com>
*
*/
namespace Core\Cache;

class Memcache extends \Core\Cache {
    private $memcache;

    public function __construct($config){
        if(!class_exists('Memcache')){
            throw new Exception('Install memcache extension first!');
        }
        $servers = $config['server'];
        $this->memcache = new Memcache();
        if(!is_array($servers)){
            $servers = array($servers);
        }
        if(!empty($servers) && is_array($servers)){
            foreach($servers as $server){
                list($host, $port) = explode(':', $server);
                !$port && $port = 11211;
                $this->memcache->addServer($host, $port);
            }
        }
    }

    public function get($key){
        return $this->memcache->get($key);
    }

    public function set($key, $value, $timeout = 0){
        return $this->memcache->set($key, $value, MEMCACHE_COMPRESSED, $timeout);
    }

    public function delete($key){
        return $this->memcache->delete($key);
    }
}