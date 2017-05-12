<?php
echo "Test pull";
$cmd = "cd ~/work/reflectionTool/ &&"
    . "git pull origin develop &&"
    . ""
    . ""
    . ""
    ;
exec('/usr/bin/git pull', $op, $rv);
print_r($op);
print_r($rv);
