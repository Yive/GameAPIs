<?php

namespace GameAPIs\Controllers\Documentation\CS;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Counter-Strike 1.6 Documentation - ');
    }

}
