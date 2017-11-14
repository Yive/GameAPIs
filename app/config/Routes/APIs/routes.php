<?php

// General API

$router->notFound([
    'namespace'     => 'GameAPIs\Controllers\Overview',
    'controller'    => 'index',
    'action'        => 'usenotfound',
]);

// 7 Days To Die

$APIs->add('/7d2d/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\SD2D\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/7d2d/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\SD2D\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/7d2d/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\SD2D\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Alien Swarm

$APIs->add('/alienswarm/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\AlienSwarm\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/alienswarm/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\AlienSwarm\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/alienswarm/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\AlienSwarm\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// ARK

$APIs->add('/ark/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\ARK\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/ark/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\ARK\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/ark/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\ARK\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Arma 3

$APIs->add('/arma3/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\ARMA3\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/arma3/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\ARMA3\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/arma3/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\ARMA3\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// ASE Protocol

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

// Battlefield 1942

$APIs->add('/bf1942/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF1942\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf1942/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF1942\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf1942/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF1942\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Battlefield 2

$APIs->add('/bf2/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF2\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf2/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF2\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf2/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF2\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Battlefield: Bad Company 2

$APIs->add('/bfbc2/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BFBC2\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bfbc2/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BFBC2\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bfbc2/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BFBC2\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Battlefield 2142

$APIs->add('/bf2142/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF2142\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf2142/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF2142\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf2142/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF2142\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Battlefield 3

$APIs->add('/bf3/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF3\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf3/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF3\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf3/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF3\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Battlefield 4

$APIs->add('/bf4/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF4\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf4/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF4\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bf4/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BF4\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Battlefield: Hardline

$APIs->add('/bfhl/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BFHL\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bfhl/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BFHL\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/bfhl/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BFHL\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// BRINK

$APIs->add('/brink/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BRINK\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/brink/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BRINK\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/brink/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\BRINK\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Conan Exiles

$APIs->add('/conanexiles/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CE\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/conanexiles/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CE\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/conanexiles/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CE\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Chivalry: Medieval Warfare

$APIs->add('/cmw/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CMW\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cmw/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CMW\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cmw/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CMW\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Call of Duty

$APIs->add('/cod/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cod/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cod/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Call of Duty 2

$APIs->add('/cod2/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD2\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cod2/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD2\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cod2/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD2\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Call of Duty 4

$APIs->add('/cod4/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD4\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cod4/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD4\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cod4/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\COD4\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Call of Duty: Modern Warfare 3

$APIs->add('/codmw3/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODMW3\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/codmw3/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODMW3\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/codmw3/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODMW3\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Call of Duty: United Offensive

$APIs->add('/coduo/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODUO\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/coduo/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODUO\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/coduo/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODUO\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Call of Duty: World at War

$APIs->add('/codwaw/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODWAW\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/codwaw/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODWAW\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/codwaw/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CODWAW\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Counter-Strike

$APIs->add('/cs/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CS\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cs/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CS\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/cs/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CS\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Counter-Strike: Global Offensive

$APIs->add('/csgo/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSGO\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/csgo/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSGO\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/csgo/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSGO\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Counter-Strike: Source

$APIs->add('/css/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSS\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/css/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSS\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/css/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\CSS\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// DayZ

$APIs->add('/dayz/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DAYZ\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dayz/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DAYZ\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dayz/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DAYZ\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Dark And Light

$APIs->add('/dnl/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DNL\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dnl/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DNL\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dnl/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DNL\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Day of Defeat

$APIs->add('/dod/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DOD\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dod/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DOD\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dod/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DOD\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Day of Defeat: Source

$APIs->add('/dods/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DODS\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dods/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DODS\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/dods/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\DODS\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// GameSpy

$APIs->add('/gamespy/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/gamespy/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/gamespy/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// GameSpy 2

$APIs->add('/gamespy2/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy2\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/gamespy2/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy2\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/gamespy2/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy2\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// GameSpy 3

$APIs->add('/gamespy3/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy3\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/gamespy3/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy3\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/gamespy3/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GameSpy3\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Garry's Mod

$APIs->add('/gmod/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GMOD\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/gmod/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GMOD\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/gmod/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\GMOD\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Minecraft

$APIs->add('/mc/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/mc/query/icon/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Icon',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/mc/query/banner/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Banner',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/mc/query/banner/{ip}/{options}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Banner',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/mcpe/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MCPE',
    'controller'    => 'info',
    'action'        => 'index'
]);

$APIs->add('/mcpe/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MCPE',
    'controller'    => 'players',
    'action'        => 'index'
]);

$APIs->add('/mcpe/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MCPE',
    'controller'    => 'status',
    'action'        => 'index'
]);

$APIs->add('/mcpe/query/motd/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MCPE',
    'controller'    => 'motd',
    'action'        => 'index'
]);

$APIs->add('/mcpe/query/extensive/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MCPE',
    'controller'    => 'extensive',
    'action'        => 'index'
]);

$APIs->add('/mc/query/motd/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\MOTD',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/mc/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/mc/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/mc/query/extensive/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Query\Extensive',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/mc/images/skin/([a-zA-Z0-9_]{1,16})', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'true'
]);

$APIs->add('/mc/images/skin/([a-zA-Z0-9_]{1,16})/true', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'true'
]);

$APIs->add('/mc/images/skin/([a-zA-Z0-9_]{1,16})/false', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'false'
]);

$APIs->add('/mc/images/skin/([a-zA-Z0-9_]{1,16})/([0-9]+)', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'true'
]);

$APIs->add('/mc/images/skin/([a-zA-Z0-9_]{1,16})/([0-9]+)/true', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'true'
]);

$APIs->add('/mc/images/skin/([a-zA-Z0-9_]{1,16})/([0-9]+)/false', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'skin',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'false'
]);

$APIs->add('/mc/images/rawskin/{name}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Skin',
    'controller'    => 'index',
    'action'        => 'rawskin'
]);



$APIs->add('/mc/images/avatar/([a-zA-Z0-9_]{1,16})', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'true'
]);

$APIs->add('/mc/images/avatar/([a-zA-Z0-9_]{1,16})/true', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'true'
]);

$APIs->add('/mc/images/avatar/([a-zA-Z0-9_]{1,16})/false', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => '85',
    'helm'          => 'false'
]);

$APIs->add('/mc/images/avatar/([a-zA-Z0-9_]{1,16})/([0-9]+)', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'true'
]);

$APIs->add('/mc/images/avatar/([a-zA-Z0-9_]{1,16})/([0-9]+)/true', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'true'
]);

$APIs->add('/mc/images/avatar/([a-zA-Z0-9_]{1,16})/([0-9]+)/false', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Images\Avatar',
    'controller'    => 'index',
    'action'        => 'avatar',
    'name'          => 1,
    'size'          => 2,
    'helm'          => 'false'
]);

$APIs->add('/mc/extra/blockedservers', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Extra\BlockedServers',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/mc/extra/blockedservers/text', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Extra\BlockedServers',
    'controller'    => 'index',
    'action'        => 'text'
]);

$APIs->add('/mc/extra/blockedservers/check/{ips}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Extra\BlockedServers',
    'controller'    => 'index',
    'action'        => 'check'
]);

$APIs->add('/mc/extra/srv', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Extra\SRV',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/mc/extra/status', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Extra\MinecraftStatus',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/mc/player/profile/{target}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Player\Profile',
    'controller'    => 'index',
    'action'        => 'first'
]);

$APIs->add('/mc/player/name/{target}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Player\Name',
    'controller'    => 'index',
    'action'        => 'first'
]);

$APIs->add('/mc/player/uuid/{target}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Minecraft\Player\UUID',
    'controller'    => 'index',
    'action'        => 'first'
]);

// Multi-Theft Auto

$APIs->add('/mta/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\MTA\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/mta/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\MTA\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/mta/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\MTA\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Quake

$APIs->add('/quake/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/quake/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/quake/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Quake 2

$APIs->add('/quake2/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake2\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/quake2/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake2\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/quake2/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake2\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Quake 3

$APIs->add('/quake3/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake3\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/quake3/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake3\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/quake3/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Quake3\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Rust

$APIs->add('/rust/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Rust\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/rust/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Rust\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/rust/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Rust\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

// Source

$APIs->add('/source/query/status/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Source\Query\Status',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/source/query/info/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Source\Query\Info',
    'controller'    => 'index',
    'action'        => 'index'
]);

$APIs->add('/source/query/players/{ip}', [
    'namespace'     => 'GameAPIs\Controllers\APIs\Source\Query\Players',
    'controller'    => 'index',
    'action'        => 'index'
]);

 ?>