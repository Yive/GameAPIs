<?php

$APIs->add('/gamespy2/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy2\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/gamespy2/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy2\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/gamespy2/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy2\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
