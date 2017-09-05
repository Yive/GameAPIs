<?php

$APIs->add('/dnl/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DNL\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dnl/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DNL\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dnl/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DNL\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
