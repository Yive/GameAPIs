<?php

namespace GameAPIs\Controllers\Documentation\BF3;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Battlefield 3 Documentation - ');
    }

}
