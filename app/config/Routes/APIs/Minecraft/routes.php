<?php

$router->add('/mc/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/mc/query/icon/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Icon',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/mcpe/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MCPE',
    'controller'    => 'info',
    'action'        => 'index'
]);
$router->add('/mcpe/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MCPE',
    'controller'    => 'players',
    'action'        => 'index'
]);

$router->add('/mcpe/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MCPE',
    'controller'    => 'status',
    'action'        => 'index'
]);

$router->add('/mcpe/query/motd/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MCPE',
    'controller'    => 'motd',
    'action'        => 'index'
]);

$router->add('/mcpe/query/extensive/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MCPE',
    'controller'    => 'extensive',
    'action'        => 'index'
]);

$router->add('/mc/query/motd/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MOTD',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/mc/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/mc/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/mc/query/extensive/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Extensive',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/mc/images/skin/([a-zA-Z0-9_]{1,16})', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'true'
]);

$router->add('/mc/images/skin/([a-zA-Z0-9_]{1,16})/true', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'true'
]);

$router->add('/mc/images/skin/([a-zA-Z0-9_]{1,16})/false', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'false'
]);

$router->add('/mc/images/skin/([a-zA-Z0-9_]{1,16})/([0-9]+)', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'true'
]);

$router->add('/mc/images/skin/([a-zA-Z0-9_]{1,16})/([0-9]+)/true', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'true'
]);

$router->add('/mc/images/skin/([a-zA-Z0-9_]{1,16})/([0-9]+)/false', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'false'
]);

$router->add('/mc/images/rawskin/{name}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'rawskin'
]);



$router->add('/mc/images/avatar/([a-zA-Z0-9_]{1,16})', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'true'
]);

$router->add('/mc/images/avatar/([a-zA-Z0-9_]{1,16})/true', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'true'
]);

$router->add('/mc/images/avatar/([a-zA-Z0-9_]{1,16})/false', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'false'
]);

$router->add('/mc/images/avatar/([a-zA-Z0-9_]{1,16})/([0-9]+)', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'true'
]);

$router->add('/mc/images/avatar/([a-zA-Z0-9_]{1,16})/([0-9]+)/true', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'true'
]);

$router->add('/mc/images/avatar/([a-zA-Z0-9_]{1,16})/([0-9]+)/false', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'false'
]);

$router->add('/mc/extra/blockedservers', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Extra\BlockedServers',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/mc/extra/blockedservers/text', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Extra\BlockedServers',
    'controller'    => 'index',
    'action'        => 'text'
]);

$router->add('/mc/extra/blockedservers/check/{ips}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Extra\BlockedServers',
    'controller'    => 'index',
    'action'        => 'check'
]);

$router->add('/mc/extra/srv', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Extra\SRV',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/mc/extra/status', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Extra\MinecraftStatus',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
