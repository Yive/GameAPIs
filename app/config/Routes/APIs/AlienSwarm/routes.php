<?php

$APIs->add('/alienswarm/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\AlienSwarm\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/alienswarm/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\AlienSwarm\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/alienswarm/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\AlienSwarm\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
