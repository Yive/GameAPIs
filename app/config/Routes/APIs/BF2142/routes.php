<?php

$APIs->add('/bf2142/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF2142\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf2142/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF2142\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf2142/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF2142\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
