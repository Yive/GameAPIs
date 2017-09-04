<?php

namespace GameAPIs\Controllers\APIs\Minecraft\Images\Avatar;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller {
    public function afterExecuteRoute() {
        $this->view->disable();
        header("Content-Type: image/png");
        header('Pragma: public');
        header('Cache-Control: max-age=600');
        header('Expires: '. gmdate('D, d M Y H:i:s \G\M\T', time() + 600));
    }
}
