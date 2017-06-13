<?php

$router->add('/docs', [
    'namespace'     => 'GameAPIs\Controllers\Documentation',
    'controller'    => 'index',
    'action'        => 'index',
]);

$router->add('/docs/', [
    'namespace'     => 'GameAPIs\Controllers\Documentation',
    'controller'    => 'index',
    'action'        => 'index',
]);

$router->add('/docs/voice', [
    'namespace'     => 'GameAPIs\Controllers\Documentation',
    'controller'    => 'index',
    'action'        => 'voice',
]);

$router->add('/docs/other', [
    'namespace'     => 'GameAPIs\Controllers\Documentation',
    'controller'    => 'index',
    'action'        => 'other',
]);

 ?>
