<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Images\Skin;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {
    public function afterExecuteRoute() {
        $this->view->disable();
        header("Content-Type: image/png");
    }
}
