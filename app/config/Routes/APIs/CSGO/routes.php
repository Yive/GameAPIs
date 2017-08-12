<?php

$APIs->add('/csgo/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSGO\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/csgo/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSGO\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/csgo/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSGO\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
