<?php

// Minecraft

$UserInterface->add('/mc/extra/blockedservers', [
    'namespace'     => 'GameAPIs\Controllers\UI\Minecraft\Extra\BlockedServers',
    'controller'    => 'index',
    'action'        => 'index',
]);

$UserInterface->add('/mc/extra/blockedservers/check/{ips}', [
    'namespace'     => 'GameAPIs\Controllers\UI\Minecraft\Extra\BlockedServers',
    'controller'    => 'index',
    'action'        => 'check'
]);

?>