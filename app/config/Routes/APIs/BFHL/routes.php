<?php

$APIs->add('/bfhl/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BFHL\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bfhl/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BFHL\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bfhl/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BFHL\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
