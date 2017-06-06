<?php

use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Php as PhpEngine;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;
use Phalcon\Mvc\Dispatcher as Dispatcher;
use Phalcon\Mvc\Router;

/**
 * Shared configuration service
 */
$di->setShared('config', function () {
    return include APP_PATH . "/config/config.php";
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new UrlResolver();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () {
    $config = $this->getConfig();

    $view = new View();
    $view->setDI($this);
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        '.phtml' => PhpEngine::class

    ]);

    return $view;
});

/**
 * Add routing capabilities
 */
$di->set('router', function () {
        $router = new Router(false);

        require __DIR__.'/Routes/Overview/routes.php';
        require __DIR__.'/Routes/Documentation/Minecraft/routes.php';
        require __DIR__.'/Routes/APIs/CSGO/routes.php';
        require __DIR__.'/Routes/APIs/Minecraft/routes.php';

        $router->setUriSource(Router::URI_SOURCE_SERVER_REQUEST_URI);
        return $router;
    }
);

$di->set('dispatcher', function () {
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('GameAPIs\Controllers');
    return $dispatcher;
});
