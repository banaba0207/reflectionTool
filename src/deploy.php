<?php
echo "Test pull";
exec('cd /home/vpsuser/reflectionTool;git pull', $op, $rv);
print_r($op);
print_r($rv);
