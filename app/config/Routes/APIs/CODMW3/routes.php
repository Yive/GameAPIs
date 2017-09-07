<?php

$APIs->add('/codmw3/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODMW3\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/codmw3/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODMW3\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/codmw3/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODMW3\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
