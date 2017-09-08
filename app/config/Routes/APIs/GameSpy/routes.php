<?php

$APIs->add('/gamespy/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/gamespy/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/gamespy/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
