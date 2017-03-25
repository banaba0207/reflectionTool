<?php

// エラー出力する場合
error_reporting(E_ALL);
ini_set('display_errors', '1');

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

// composerのautoload読み込み
require_once dirname(__DIR__) . "/vendor/autoload.php";

require_once __DIR__ . '/Dispatcher.php';
$dispatcher = new Dispatcher();
$dispatcher->setSystemRoot(dirname(__DIR__));
$dispatcher->dispatch();
