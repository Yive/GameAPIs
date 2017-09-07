<?php

$APIs->add('/codwaw/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODWAW\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/codwaw/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODWAW\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/codwaw/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODWAW\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
