<?php

$router->add('/api/minecraft/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/minecraft/query/icon/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Icon',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/minecraft/query/mcpe/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MCPE',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/minecraft/query/motd/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MOTD',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/minecraft/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/minecraft/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/minecraft/query/extensive/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Extensive',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/minecraft/images/skin/([a-zA-Z0-9_]{1,16})', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'true'
]);

$router->add('/api/minecraft/images/skin/([a-zA-Z0-9_]{1,16})/true', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'true'
]);

$router->add('/api/minecraft/images/skin/([a-zA-Z0-9_]{1,16})/false', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'false'
]);

$router->add('/api/minecraft/images/skin/([a-zA-Z0-9_]{1,16})/([0-9]+)', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'true'
]);

$router->add('/api/minecraft/images/skin/([a-zA-Z0-9_]{1,16})/([0-9]+)/true', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'true'
]);

$router->add('/api/minecraft/images/skin/([a-zA-Z0-9_]{1,16})/([0-9]+)/false', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'false'
]);

$router->add('/api/minecraft/images/rawskin/{name}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'rawskin'
]);



$router->add('/api/minecraft/images/avatar/([a-zA-Z0-9_]{1,16})', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'true'
]);

$router->add('/api/minecraft/images/avatar/([a-zA-Z0-9_]{1,16})/true', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'true'
]);

$router->add('/api/minecraft/images/avatar/([a-zA-Z0-9_]{1,16})/false', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'false'
]);

$router->add('/api/minecraft/images/avatar/([a-zA-Z0-9_]{1,16})/([0-9]+)', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'true'
]);

$router->add('/api/minecraft/images/avatar/([a-zA-Z0-9_]{1,16})/([0-9]+)/true', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'true'
]);

$router->add('/api/minecraft/images/avatar/([a-zA-Z0-9_]{1,16})/([0-9]+)/false', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'false'
]);

$router->add('/api/minecraft/extra/blockedservers', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Extra\BlockedServers',
    'controller'    => 'index',
    'action'        => 'index'
]);

$router->add('/api/minecraft/extra/blockedservers/check/{ips}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Extra\BlockedServers',
    'controller'    => 'index',
    'action'        => 'check'
]);

$router->add('/api/minecraft/extra/srv', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Extra\SRV',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>
