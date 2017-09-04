<?php

$APIs->add('/conanexiles/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CE\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/conanexiles/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CE\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/conanexiles/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CE\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
