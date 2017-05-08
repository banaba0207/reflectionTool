<?php
echo "Test pull";
exec('/usr/bin/git pull', $op, $rv);
print_r($op);
print_r($rv);
