<?php
echo "Test pull";
$cpFileList = [
    'controller',
    'deploy.php',
    'logic',
    'model',
    'view',
    'plugin',
    'public_html',
    'index.html',
    '.htaccess',
    'vendor',
];
$cmd = "cd /home/vpsuser/work/reflectionTool/src &&"
    . "git pull origin develop &&"
    . "cp -r " . implode(" ", $cpFileList) . " /var/www/html/ "
    ;
exec($cmd, $op, $rv);
print_r($op);
print_r($rv);
