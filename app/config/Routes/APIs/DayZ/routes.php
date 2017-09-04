<?php

$APIs->add('/dayz/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DAYZ\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dayz/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DAYZ\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dayz/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DAYZ\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
