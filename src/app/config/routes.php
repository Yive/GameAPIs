<?php

use \Phalcon\Mvc\Router;

$router = new Router(false);

$router->add('/', [
    'controller' => 'index',
    'action'     => 'index',
]);

$router->add('/supported/:action', [
    'controller' => 'supported',
    'action'     => 1
]);

$router->notFound([
    'controller' => 'index',
    'action'     => 'notfound',
]);

$router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);
return $router;
