<?php

define('LOCK_HORN', '/tmp/hornlock');

$run = '/usr/bin/php /home/pplive/web/horn.php >/dev/null 2>&1 &';

$f = fopen(LOCK_HORN,'w');

$lock = flock($f, LOCK_EX|LOCK_NB);

if ($lock) {

    exec($run);

    echo "RUN AGAIN\n";

}

flock($f, LOCK_UN);