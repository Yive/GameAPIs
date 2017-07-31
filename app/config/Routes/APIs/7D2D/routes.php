<?php

$APIs->add('/7d2d/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\SD2D\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/7d2d/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\SD2D\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/7d2d/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\SD2D\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
