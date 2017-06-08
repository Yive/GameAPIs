<?php

$router->add('/api/cs/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CS\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/cs/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CS\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/cs/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CS\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
