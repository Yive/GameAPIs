<?php

$APIs->add('/arma3/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\ARMA3\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/arma3/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\ARMA3\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/arma3/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\ARMA3\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
