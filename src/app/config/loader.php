<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir
    ]
);

$loader->registerNamespaces(
    [
        'GameAPIs\Controllers'              => $config->application->controllersDir,
        'GameAPIs\Controllers\Supported'    => $config->application->controllersDir.'Supported/',
        'GameAPIs\Controllers\Minecraft'    => $config->application->controllersDir.'Minecraft/'
    ]
);

$loader->register();
