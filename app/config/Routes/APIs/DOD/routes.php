<?php

$APIs->add('/dod/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DOD\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dod/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DOD\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dod/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DOD\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
