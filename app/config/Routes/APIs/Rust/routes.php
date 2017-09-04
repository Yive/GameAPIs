<?php

$APIs->add('/rust/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Rust\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/rust/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Rust\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/rust/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Rust\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
