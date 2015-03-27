<?php

$cache = \Core\Cache::instance('config');
$options = \Logic\Option::fetch();
$config = array();
foreach ($options as $option)
{
    $config[$option->key] = $option->value;
}
$cache->set('option', $config);