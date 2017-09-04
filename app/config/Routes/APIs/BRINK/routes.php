<?php

$APIs->add('/brink/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BRINK\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/brink/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BRINK\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/brink/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BRINK\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
