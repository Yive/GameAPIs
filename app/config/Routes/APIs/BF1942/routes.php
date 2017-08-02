<?php

$router->add('/bf1942/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF1942\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/bf1942/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF1942\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/bf1942/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF1942\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
