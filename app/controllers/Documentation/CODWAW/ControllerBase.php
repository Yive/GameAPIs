<?php

namespace GameAPIs\Controllers\Documentation\CODWAW;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {
    public function afterExecuteRoute() {
        $this->view->setPartialsDir($this->view->getViewsDir() . 'partials/');
        $this->view->setViewsDir($this->view->getViewsDir() . 'Documentation/CODWAW/');
    }
}
