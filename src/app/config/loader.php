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
        'GameAPIs\Controllers'                                      => $config->application->controllersDir,
        'GameAPIs\Controllers\Documentation'                        => $config->application->controllersDir.'Documentation/',
        'GameAPIs\Controllers\Documentation\Minecraft'              => $config->application->controllersDir.'Documentation/Minecraft/',
        'GameAPIs\Controllers\Documentation\Minecraft\Extra'        => $config->application->controllersDir.'Documentation/Minecraft/Extra/',
        'GameAPIs\Controllers\Documentation\Minecraft\Query'        => $config->application->controllersDir.'Documentation/Minecraft/Query/',
        'GameAPIs\Controllers\Documentation\Minecraft\Images'       => $config->application->controllersDir.'Documentation/Minecraft/Images/',
        'GameAPIs\Controllers\Documentation\Minecraft\Ecommerce'    => $config->application->controllersDir.'Documentation/Minecraft/Ecommerce/',
        'GameAPIs\Controllers\APIs\Minecraft'                       => $config->application->controllersDir.'APIs/Minecraft/',
        'GameAPIs\Controllers\APIs\Minecraft\Extra'                 => $config->application->controllersDir.'APIs/Minecraft/Extra/',
        'GameAPIs\Controllers\APIs\Minecraft\Query'                 => $config->application->controllersDir.'APIs/Minecraft/Query/',
        'GameAPIs\Controllers\APIs\Minecraft\Images'                => $config->application->controllersDir.'APIs/Minecraft/Images/',
        'GameAPIs\Controllers\APIs\Minecraft\Ecommerce'             => $config->application->controllersDir.'APIs/Minecraft/Ecommerce/'
    ]
);

$loader->register();
