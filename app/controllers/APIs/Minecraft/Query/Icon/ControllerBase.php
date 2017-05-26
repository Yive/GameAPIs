<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Query\Icon;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {
    public function afterExecuteRoute() {
        $this->view->disable();
        header("Content-Type: application/json; charset=UTF-8");
    }
}
