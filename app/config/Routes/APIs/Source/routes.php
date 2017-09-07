<?php

$APIs->add('/source/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Source\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/source/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Source\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/source/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Source\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
