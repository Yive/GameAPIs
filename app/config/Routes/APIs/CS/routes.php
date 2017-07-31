<?php

$router->add('/cs/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CS\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/cs/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CS\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/cs/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CS\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
