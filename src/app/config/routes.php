<?php

use \Phalcon\Mvc\Router;

$router = new Router(false);

$router->add('/', [
    'namespace'     => 'GameAPIs\Controllers',
    'controller'    => 'index',
    'action'        => 'index',
]);

$router->add('/supported/:action', [
    'namespace'     => 'GameAPIs\Controllers\Supported',
    'controller'    => 'index',
    'action'        => 1
]);

$router->add('/supported/minecraft/:action', [
    'namespace'     => 'GameAPIs\Controllers\Supported',
    'controller'    => 'minecraft',
    'action'        => 1
]);

$router->add('/supported/minecraft/query/:action', [
    'namespace'     => 'GameAPIs\Controllers\Supported\Minecraft',
    'controller'    => 'query',
    'action'        => 1
]);

$router->add('/supported/minecraft/images/:action', [
    'namespace'     => 'GameAPIs\Controllers\Supported\Minecraft',
    'controller'    => 'images',
    'action'        => 1
]);

$router->add('/supported/minecraft/ecommerce/:action', [
    'namespace'     => 'GameAPIs\Controllers\Supported\Minecraft',
    'controller'    => 'ecommerce',
    'action'        => 1
]);

$router->add('/supported/minecraft/extra/:action', [
    'namespace'     => 'GameAPIs\Controllers\Supported\Minecraft',
    'controller'    => 'extra',
    'action'        => 1
]);

$router->notFound([
    'namespace'     => 'GameAPIs\Controllers',
    'controller'    => 'index',
    'action'        => 'notfound',
]);

$router->removeExtraSlashes(true);
$router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);
return $router;
