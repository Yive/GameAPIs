<?php
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
    'application' => [
        'appDir'            => APP_PATH . '/',
        'controllersDir'    => APP_PATH . '/controllers/',
        'modelsDir'         => APP_PATH . '/models/',
        'migrationsDir'     => APP_PATH . '/migrations/',
        'viewsDir'          => APP_PATH . '/views/',
        'pluginsDir'        => APP_PATH . '/plugins/',
        'libraryDir'        => APP_PATH . '/library/',
        'cacheDir'          => BASE_PATH . '/cache/',

        'baseUri'           => '/',
        'redis'             => [
            'host'              => '/var/run/redis/redis-server.sock',
            'keyStructure'          => [
                'sd2d'                  => [
                    'ping'                  => 'gameapis:7d2d:ping:'
                ],
                'alienswarm'            => [
                    'ping'                  => 'gameapis:alienswarm:ping:'
                ],
                'ark'                   => [
                    'ping'                  => 'gameapis:ark:ping:'
                ],
                'arma3'                 => [
                    'ping'                  => 'gameapis:arma3:ping:'
                ],
                'ase'                   => [
                    'ping'                  => 'gameapis:ase:ping:'
                ],
                'bf2'                   => [
                    'ping'                  => 'gameapis:bf2:ping:'
                ],
                'bf3'                   => [
                    'ping'                  => 'gameapis:bf3:ping:'
                ],
                'bf4'                   => [
                    'ping'                  => 'gameapis:bf4:ping:'
                ],
                'bf1942'                => [
                    'ping'                  => 'gameapis:bf1942:ping:'
                ],
                'bf2142'                => [
                    'ping'                  => 'gameapis:bf2142:ping:'
                ],
                'bfbc2'                 => [
                    'ping'                  => 'gameapis:bfbc2:ping:'
                ],
                'bfhl'                  => [
                    'ping'                  => 'gameapis:bfhl:ping:'
                ],
                'brink'                 => [
                    'ping'                  => 'gameapis:brink:ping:'
                ],
                'conanexiles'           => [
                    'ping'                  => 'gameapis:conanexiles:ping:'
                ],
                'cod'                   => [
                    'ping'                  => 'gameapis:cod:ping:'
                ],
                'cod2'                  => [
                    'ping'                  => 'gameapis:cod2:ping:'
                ],
                'cod4'                  => [
                    'ping'                  => 'gameapis:cod4:ping:'
                ],
                'codmw3'                => [
                    'ping'                  => 'gameapis:codmw3:ping:'
                ],
                'coduo'                 => [
                    'ping'                  => 'gameapis:coduo:ping:'
                ],
                'codwaw'                => [
                    'ping'                  => 'gameapis:codwaw:ping:'
                ],
                'cs16'                  => [
                    'ping'                  => 'gameapis:cs16:ping:'
                ],
                'csgo'                  => [
                    'ping'                  => 'gameapis:csgo:ping:'
                ],
                'css'                   => [
                    'ping'                  => 'gameapis:css:ping:'
                ],
                'dod'                  => [
                    'ping'                  => 'gameapis:dod:ping:'
                ],
                'dods'                  => [
                    'ping'                  => 'gameapis:dods:ping:'
                ],
                'dayz'                  => [
                    'ping'                  => 'gameapis:dayz:ping:'
                ],
                'dnl'                   => [
                    'ping'                  => 'gameapis:dnl:ping:'
                ],
                'gamespy'               => [
                    'ping'                  => 'gameapis:gamespy:ping:'
                ],
                'gamespy2'              => [
                    'ping'                  => 'gameapis:gamespy2:ping:'
                ],
                'gamespy3'              => [
                    'ping'                  => 'gameapis:gamespy3:ping:'
                ],
                'gmod'                  => [
                    'ping'                  => 'gameapis:gmod:ping:'
                ],
                'mcpc'                  => [
                    'ping'                  => 'gameapis:mcpc:ping:',
                    'query'                 => 'gameapis:mcpc:query:',
                    'avatar'                => 'gameapis:mcpc:avatar:',
                    'skin'                  => [
                        'render'                => 'gameapis:mcpc:skin:render:',
                        'rawfile'               => 'gameapis:mcpc:skin:rawfile:'
                    ],
                    'blockedservers'        => [
                        'list'                  => 'gameapis:mcpc:blockedservers:list',
                        'check'                 => 'gameapis:mcpc:blockedservers:check:',
                        'listExtended'          => 'gameapis:mcpc:blockedservers:listExtended'
                    ],
                    'player'                => [
                        'avoid'                 => 'gameapis:mcpc:player:avoid:',
                        'profile'               => 'gameapis:mcpc:player:profile:',
                        'overloaded'            => 'gameapis:mcpc:player:overloaded'
                    ],
                    'mcstatus'              => 'gameapis:mcpc:mcstatus',
                    'buycraft'              => 'gameapis:mcpc:buycraft:',
                    'minecraftmarket'       => 'gameapis:mcpc:minecraftmarket:',
                    'tracker'               => 'gameapis:mcpc:tracker:',
                    'srv'                   => 'gameapis:mcpc:srv:'
                ],
                'mcpe'                  => [
                    'ping'                   => 'gameapis:mcpe:ping:',
                    'query'                  => 'gameapis:mcpe:query:'
                ],
                'quake'                 => [
                    'ping'                  => 'gameapis:quake:ping:'
                ],
                'quake2'                => [
                    'ping'                  => 'gameapis:quake2:ping:'
                ],
                'quake3'                => [
                    'ping'                  => 'gameapis:quake3:ping:'
                ],
                'quakelive'             => [
                    'ping'                  => 'gameapis:quakelive:ping:'
                ],
                'rust'                  => [
                    'ping'                  => 'gameapis:rust:ping:'
                ],
                'source'                => [
                    'ping'                  => 'gameapis:source:ping:'
                ]
            ]
        ]
    ]
]);
