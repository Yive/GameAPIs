<?php

$APIs->add('/cod4/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD4\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cod4/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD4\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cod4/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD4\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
