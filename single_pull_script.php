<?php
define('DIR_MATCH', '/tmp/match/');

if (!is_dir(DIR_MATCH))
    mkdir(DIR_MATCH, 0777);
if (!is_dir(DIR_MATCH))
    exit("Please set dir first:\n" . DIR_MATCH . "\n");

$pre = 'http://admin.matchlive.client.pptv.com/api/';

$urlMatch = $pre . 'matches?format=json';
$data = file_get_contents($urlMatch);
if ($data)
{
    $data_old = @file_get_contents(DIR_MATCH . "matches.json");
    if ($data!=$data_old)
    {
        $rs = (int)@file_put_contents(DIR_MATCH . "matches.json", $data);
        echo "set matches : {$rs}" . PHP_EOL;
    }
    else
        echo "matches is no changed" . PHP_EOL;
}
else
    echo "matches data fetch failed" . PHP_EOL;



$urlConfig = $pre . 'config?prekey=ec&format=jsonp&cb=cb_config';
$data = file_get_contents($urlConfig);
if ($data)
{
    $data_old = @file_get_contents(DIR_MATCH . "config.jsonp");
    if ($data!=$data_old)
    {
        $rs = (int)@file_put_contents(DIR_MATCH . "config.jsonp", $data);
        echo "set config : {$rs}" . PHP_EOL;
    }
    else
        echo "config is no changed" . PHP_EOL;
}
else
    echo "config data fetch failed" . PHP_EOL;



$urlIds = $pre . 'matchids?format=json';
$ids = file_get_contents($urlIds);
if (!$ids)
    exit('ids empty' . PHP_EOL);

$ids = json_decode($ids, true);
if (!$ids || !is_array($ids))
    exit('ids format error' . PHP_EOL);

foreach ($ids as $id)
{
    $urlInfo = $pre . "matchdetails?id={$id}&format=jsonp&cb=matchdetail";
    $data = file_get_contents($urlInfo);
    if ($data)
    {
        $data_old = @file_get_contents(DIR_MATCH . "match_{$id}.jsonp");
        if ($data!=$data_old)
        {
            $rs = (int)@file_put_contents(DIR_MATCH . "match_{$id}.jsonp", $data);
            echo "set match {$id} : {$rs}" . PHP_EOL;
        }
        else
            echo "match {$id} is no changed" . PHP_EOL;
    }
    else
         echo "match {$id} data fetch failed" . PHP_EOL;
}
