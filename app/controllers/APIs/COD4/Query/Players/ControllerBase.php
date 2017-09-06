<?php

namespace GameAPIs\Controllers\APIs\COD4\Query\Players;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {
    public function afterExecuteRoute() {
        $this->view->disable();
        header("Content-Type: application/json; charset=UTF-8");
    }
}
