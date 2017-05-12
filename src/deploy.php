<?php
echo "Test pull";
$cmd = "cd ~/work/reflectionTool/ &&"
    . "git pull origin develop &&"
    . "ls"
    . ""
    . ""
    ;
exec($cmd, $op, $rv);
print_r($op);
print_r($rv);
