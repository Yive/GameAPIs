<?php

namespace GameAPIs\Controllers\Documentation\BF4;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Battlefield 4 Documentation - ');
    }

}
