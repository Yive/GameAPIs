<?php

namespace GameAPIs\Controllers\APIs\Minecraft;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {
    public function afterExecuteRoute() {
        $this->view->disable();
    }
}
