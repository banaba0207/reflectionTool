<?php
echo "Test pull";
$cpFileList = ['controller', 'deploy.php', 'logic', 'model', 'view', 'public_html', 'index.html'];
$cmd = "cd ~/work/reflectionTool/ &&"
    . "git pull origin develop &&"
    . "cp -r " . implode(" ", $cpFileList) . " /var/www/html/ "
    ;
exec($cmd, $op, $rv);
print_r($op);
print_r($rv);
