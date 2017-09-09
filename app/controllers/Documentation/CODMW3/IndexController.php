<?php

namespace GameAPIs\Controllers\Documentation\CODMW3;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Call of Duty: Modern Warfare 3 Documentation - ');
    }

}
