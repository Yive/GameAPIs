<?php

$APIs->add('/cmw/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CMW\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cmw/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CMW\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cmw/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CMW\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
