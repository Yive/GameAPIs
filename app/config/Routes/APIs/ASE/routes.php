<?php

$APIs->add('/ase/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\ASE\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/ase/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\ASE\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/ase/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\ASE\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
