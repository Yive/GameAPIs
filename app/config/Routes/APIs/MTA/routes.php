<?php

$APIs->add('/mta/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\MTA\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/mta/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\MTA\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/mta/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\MTA\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
