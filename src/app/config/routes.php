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

$router->notFound([
    'namespace'     => 'GameAPIs\Controllers',
    'controller'    => 'index',
    'action'        => 'notfound',
]);

$router->removeExtraSlashes(true);
$router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);
return $router;
