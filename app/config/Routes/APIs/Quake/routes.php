<?php

$APIs->add('/quake/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/quake/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/quake/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
