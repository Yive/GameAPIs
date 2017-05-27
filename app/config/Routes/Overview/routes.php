<?php

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

 ?>
