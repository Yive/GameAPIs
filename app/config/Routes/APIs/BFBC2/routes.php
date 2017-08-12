<?php

$APIs->add('/bfbc2/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BFBC2\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bfbc2/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BFBC2\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bfbc2/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BFBC2\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
