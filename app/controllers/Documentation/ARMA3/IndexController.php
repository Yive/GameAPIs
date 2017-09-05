<?php

namespace GameAPIs\Controllers\Documentation\ARMA3;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('ARMA3 Documentation - ');
    }

}
