<?php

$APIs->add('/gamespy3/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy3\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/gamespy3/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy3\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/gamespy3/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy3\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
