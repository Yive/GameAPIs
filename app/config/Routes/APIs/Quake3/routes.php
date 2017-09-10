<?php

$APIs->add('/quake3/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake3\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/quake3/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake3\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/quake3/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake3\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
