<?php

$APIs->add('/quake2/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake2\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/quake2/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake2\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/quake2/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake2\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
