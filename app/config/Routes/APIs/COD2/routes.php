<?php

$APIs->add('/cod2/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD2\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cod2/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD2\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cod2/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD2\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
