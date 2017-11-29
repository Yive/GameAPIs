<?php

namespace GameAPIs\Controllers\UI\Minecraft\Extra\MinecraftStatus;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {
    public function afterExecuteRoute() {
        $this->view->setPartialsDir($this->view->getViewsDir() . 'partials/');
        $this->view->setViewsDir($this->view->getViewsDir() . 'UI/Minecraft/Extra/MinecraftStatus/');
    }
}
