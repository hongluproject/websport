<?php
/**
 * XCache
 * @author Corrie Zhao <hfcorriez@gmail.com>
 *
 */
namespace Core\Cache;

class Xcache extends \Core\Cache {
    public function set($key, $value, $expire=0){
        return xcache_set($key, $value, $expire);
    }
    
    public function get($key){
        return xcache_get($key);
    }
    
    public function delete($key){
        return xcache_unset($key);
    }
}