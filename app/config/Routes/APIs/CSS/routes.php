<?php

$router->add('/api/css/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSS\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/css/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSS\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/css/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSS\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
