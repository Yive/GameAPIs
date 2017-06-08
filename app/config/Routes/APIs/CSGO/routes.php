<?php

$router->add('/api/csgo/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSGO\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/csgo/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSGO\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/csgo/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSGO\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
