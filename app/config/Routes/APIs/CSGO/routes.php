<?php

$router->add('/api/csgo/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSGO\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
