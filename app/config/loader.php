<?php

$loader = new \Phalcon\Loader();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->libraryDir
    ]
);

$loader->registerNamespaces(
    [
        'GameAPIs\Controllers'                                          => $config->application->controllersDir,
        'GameAPIs\Controllers\Overview'                                 => $config->application->controllersDir.'Overview/',
        'GameAPIs\Controllers\Documentation'                            => $config->application->controllersDir.'Documentation/',
        // 7 Days to Die Documentation //
        'GameAPIs\Controllers\Documentation\SD2D'                       => $config->application->controllersDir.'Documentation/7D2D/',
        // Alien Swarm Documentation //
        'GameAPIs\Controllers\Documentation\AlienSwarm'                 => $config->application->controllersDir.'Documentation/AlienSwarm/',
        // Minecraft Documentation //
        'GameAPIs\Controllers\Documentation\Minecraft'                  => $config->application->controllersDir.'Documentation/Minecraft/',
        'GameAPIs\Controllers\Documentation\Minecraft\Extra'            => $config->application->controllersDir.'Documentation/Minecraft/Extra/',
        'GameAPIs\Controllers\Documentation\Minecraft\Query'            => $config->application->controllersDir.'Documentation/Minecraft/Query/',
        'GameAPIs\Controllers\Documentation\Minecraft\Images'           => $config->application->controllersDir.'Documentation/Minecraft/Images/',
        'GameAPIs\Controllers\Documentation\Minecraft\Ecommerce'        => $config->application->controllersDir.'Documentation/Minecraft/Ecommerce/',
        // Minecraft UIs //
        'GameAPIs\Controllers\UI\Minecraft\Extra'                       => $config->application->controllersDir.'UI/Minecraft/Extra/'
    ]
);

$loader->register();
