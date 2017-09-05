<?php

$APIs->add('/cod/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cod/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cod/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
