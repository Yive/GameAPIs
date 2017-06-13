<?php

$router->add('/docs/mc', [
    'namespace'     => 'GameAPIs\Controllers\Documentation\Minecraft',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/docs/mc/:action', [
    'namespace'     => 'GameAPIs\Controllers\Documentation\Minecraft',
    'controller'    => 'index',
    'action'        => 1
]);

$router->add('/docs/mc/query/:controller', [
    'namespace'     => 'GameAPIs\Controllers\Documentation\Minecraft\Query',
    'controller'    => 1,
    'action'        => 'index'
]);

$router->add('/docs/mc/images/:controller', [
    'namespace'     => 'GameAPIs\Controllers\Documentation\Minecraft\Images',
    'controller'    => 1,
    'action'        => 'index'
]);

$router->add('/docs/mc/ecommerce/:controller', [
    'namespace'     => 'GameAPIs\Controllers\Documentation\Minecraft\Ecommerce',
    'controller'    => 1,
    'action'        => 'index'
]);

$router->add('/docs/mc/extra/:controller', [
    'namespace'     => 'GameAPIs\Controllers\Documentation\Minecraft\Extra',
    'controller'    => 1,
    'action'        => 'index'
]);

 ?>
