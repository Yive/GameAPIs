<?php

use \Phalcon\Mvc\Router;

$router = new Router(false);

$router->notFound([
    'namespace'     => 'GameAPIs\Controllers\Overview',
    'controller'    => 'index',
    'action'        => 'notfound',
]);

$router->add('/', [
    'namespace'     => 'GameAPIs\Controllers\Overview',
    'controller'    => 'index',
    'action'        => 'index',
]);

$router->add('/docs/minecraft/:action', [
    'namespace'     => 'GameAPIs\Controllers\Documentation\Minecraft',
    'controller'    => 'index',
    'action'        => 1
]);

$router->add('/docs/minecraft/query/:controller', [
    'namespace'     => 'GameAPIs\Controllers\Documentation\Minecraft\Query',
    'controller'    => 1,
    'action'        => 'index'
]);

$router->add('/docs/minecraft/images/:controller', [
    'namespace'     => 'GameAPIs\Controllers\Documentation\Minecraft\Images',
    'controller'    => 1,
    'action'        => 'index'
]);

$router->add('/docs/minecraft/ecommerce/:controller', [
    'namespace'     => 'GameAPIs\Controllers\Documentation\Minecraft\Ecommerce',
    'controller'    => 1,
    'action'        => 'index'
]);

$router->add('/docs/minecraft/extra/:controller', [
    'namespace'     => 'GameAPIs\Controllers\Documentation\Minecraft\Extra',
    'controller'    => 1,
    'action'        => 'index'
]);

$router->add('/api/minecraft/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/minecraft/query/icon/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Icon',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/minecraft/query/mcpe/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MCPE',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/minecraft/query/motd/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MOTD',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/minecraft/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/minecraft/query/extensive/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Extensive',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);
return $router;
