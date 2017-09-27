<?php

$APIs->add('/dods/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DODS\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dods/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DODS\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dods/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DODS\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
