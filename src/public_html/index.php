<?php
require_once 'public_html/Dispatcher.php';
$dispatcher = new Dispatcher();
$dispatcher->setSystemRoot('.');
$dispatcher->dispatch();
