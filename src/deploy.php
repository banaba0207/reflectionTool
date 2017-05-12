<?php
echo "Test pull";
$cmd = "cd ~/work/reflectionTool/;"
    . ""
    . ""
    . ""
    . ""
    ;
exec('/usr/bin/git pull', $op, $rv);
print_r($op);
print_r($rv);
