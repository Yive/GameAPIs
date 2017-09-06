<?php

$APIs->add('/coduo/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODUO\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/coduo/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODUO\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/coduo/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODUO\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
