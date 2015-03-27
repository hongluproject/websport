<?php
/**
 * Apc Cache
 * @author Corrie Zhao <hfcorriez@gmail.com>
 *
 */
namespace Core\Cache;

class Apc extends \Core\Cache {
    public function set($key, $value, $expire=0){
        return apc_store($key, $value, $expire);
    }

    public function get($key){
        return apc_fetch($key);
    }

    public function delete($key){
        return apc_delete($key);
    }
}