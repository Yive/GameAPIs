<?php

$router->notFound([
    'namespace'     => 'GameAPIs\Controllers\Overview',
    'controller'    => 'index',
    'action'        => 'notfound',
]);

$Overview->add('/', [
    'namespace'     => 'GameAPIs\Controllers\Overview',
    'controller'    => 'index',
    'action'        => 'index',
]);

 ?>
