<?php

namespace GameAPIs\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {
    $this->view->setPartialsDir($this->view->getViewsDir() . 'partials/');

}
