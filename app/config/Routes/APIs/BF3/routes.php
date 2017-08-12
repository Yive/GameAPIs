<?php

$APIs->add('/bf3/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF3\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf3/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF3\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf3/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF3\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
