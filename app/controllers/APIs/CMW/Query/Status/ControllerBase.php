<?php

namespace GameAPIs\Controllers\APIs\CMW\Query\Status;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {
    public function afterExecuteRoute() {
        $this->view->disable();
        header("Content-Type: application/json; charset=UTF-8");
    }
}
