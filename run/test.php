<?php

#!/usr/bin/php -q
# print date("Y-m-d H:i:s").'\n';
file_put_contents('/home/web/horn/run/crontab/logs/test.log', "test\n", FILE_APPEND);
print "testoutput" . PHP_EOL;

?>
