<?php

namespace GameAPIs\Controllers\Documentation\BF2;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Battlefield 2 Documentation - ');
    }

}
