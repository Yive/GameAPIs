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
         // Minecraft Documentation //
        'GameAPIs\Controllers\Documentation\Minecraft'                  => $config->application->controllersDir.'Documentation/Minecraft/',
        'GameAPIs\Controllers\Documentation\Minecraft\Extra'            => $config->application->controllersDir.'Documentation/Minecraft/Extra/',
        'GameAPIs\Controllers\Documentation\Minecraft\Query'            => $config->application->controllersDir.'Documentation/Minecraft/Query/',
        'GameAPIs\Controllers\Documentation\Minecraft\Images'           => $config->application->controllersDir.'Documentation/Minecraft/Images/',
        'GameAPIs\Controllers\Documentation\Minecraft\Ecommerce'        => $config->application->controllersDir.'Documentation/Minecraft/Ecommerce/',
         // Minecraft APIs //
        'GameAPIs\Controllers\APIs\Minecraft'                           => $config->application->controllersDir.'APIs/Minecraft/',
        'GameAPIs\Controllers\APIs\Minecraft\Extra'                     => $config->application->controllersDir.'APIs/Minecraft/Extra/',
        'GameAPIs\Controllers\APIs\Minecraft\Extra\SRV'                 => $config->application->controllersDir.'APIs/Minecraft/Extra/SRV/',
        'GameAPIs\Controllers\APIs\Minecraft\Extra\BlockedServers'      => $config->application->controllersDir.'APIs/Minecraft/Extra/BlockedServers/',
        'GameAPIs\Controllers\APIs\Minecraft\Extra\MinecraftStatus'     => $config->application->controllersDir.'APIs/Minecraft/Extra/MinecraftStatus/',
        'GameAPIs\Controllers\APIs\Minecraft\Query'                     => $config->application->controllersDir.'APIs/Minecraft/Query/',
        'GameAPIs\Controllers\APIs\Minecraft\Query\Info'                => $config->application->controllersDir.'APIs/Minecraft/Query/Info/',
        'GameAPIs\Controllers\APIs\Minecraft\Query\Icon'                => $config->application->controllersDir.'APIs/Minecraft/Query/Icon/',
        'GameAPIs\Controllers\APIs\Minecraft\Query\MOTD'                => $config->application->controllersDir.'APIs/Minecraft/Query/MOTD/',
        'GameAPIs\Controllers\APIs\Minecraft\Query\MCPE'                => $config->application->controllersDir.'APIs/Minecraft/Query/MCPE/',
        'GameAPIs\Controllers\APIs\Minecraft\Query\Players'             => $config->application->controllersDir.'APIs/Minecraft/Query/Players/',
        'GameAPIs\Controllers\APIs\Minecraft\Query\Extensive'           => $config->application->controllersDir.'APIs/Minecraft/Query/Extensive/',
        'GameAPIs\Controllers\APIs\Minecraft\Images'                    => $config->application->controllersDir.'APIs/Minecraft/Images/',
        'GameAPIs\Controllers\APIs\Minecraft\Images\Skin'               => $config->application->controllersDir.'APIs/Minecraft/Images/Skin/',
        'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar'             => $config->application->controllersDir.'APIs/Minecraft/Images/Avatar/',
        'GameAPIs\Controllers\APIs\Minecraft\Tracker'                   => $config->application->controllersDir.'APIs/Minecraft/Tracker/',
        'GameAPIs\Controllers\APIs\Minecraft\Tracker\Player'            => $config->application->controllersDir.'APIs/Minecraft/Tracker/Player/',
        'GameAPIs\Controllers\APIs\Minecraft\Tracker\Server'            => $config->application->controllersDir.'APIs/Minecraft/Tracker/Server/',
        'GameAPIs\Controllers\APIs\Minecraft\Ecommerce'                 => $config->application->controllersDir.'APIs/Minecraft/Ecommerce/',
        'GameAPIs\Controllers\APIs\Minecraft\Ecommerce\Buycraft'        => $config->application->controllersDir.'APIs/Minecraft/Ecommerce/Buycraft/',
        'GameAPIs\Controllers\APIs\Minecraft\Ecommerce\MinecraftMarket' => $config->application->controllersDir.'APIs/Minecraft/Ecommerce/MinecraftMarket/',
         // CSGO APIs //
        'GameAPIs\Controllers\APIs\CSGO\Query'                          => $config->application->controllersDir.'APIs/CSGO/Query/',
        'GameAPIs\Controllers\APIs\CSGO\Query\Info'                     => $config->application->controllersDir.'APIs/CSGO/Query/Info/',
        'GameAPIs\Controllers\APIs\CSGO\Query\Status'                   => $config->application->controllersDir.'APIs/CSGO/Query/Status/',
        'GameAPIs\Controllers\APIs\CSGO\Query\Players'                  => $config->application->controllersDir.'APIs/CSGO/Query/Players/',
         // CSS APIs //
        'GameAPIs\Controllers\APIs\CSS\Query'                           => $config->application->controllersDir.'APIs/CSS/Query/',
        'GameAPIs\Controllers\APIs\CSS\Query\Info'                      => $config->application->controllersDir.'APIs/CSS/Query/Info/',
        'GameAPIs\Controllers\APIs\CSS\Query\Status'                    => $config->application->controllersDir.'APIs/CSS/Query/Status/',
        'GameAPIs\Controllers\APIs\CSS\Query\Players'                   => $config->application->controllersDir.'APIs/CSS/Query/Players/',
         // CS 1.6 APIs //
        'GameAPIs\Controllers\APIs\CS\Query'                            => $config->application->controllersDir.'APIs/CS/Query/',
        'GameAPIs\Controllers\APIs\CS\Query\Info'                       => $config->application->controllersDir.'APIs/CS/Query/Info/',
        'GameAPIs\Controllers\APIs\CS\Query\Status'                     => $config->application->controllersDir.'APIs/CS/Query/Status/',
        'GameAPIs\Controllers\APIs\CS\Query\Players'                    => $config->application->controllersDir.'APIs/CS/Query/Players/',
         // Libraries //
        'GameAPIs\Libraries\Minecraft\Query'                            => $config->application->libraryDir.'Minecraft/Query/'
    ]
);

$loader->register();
