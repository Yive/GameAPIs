<?php

$APIs->add('/bf2/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF2\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf2/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF2\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf2/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF2\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
