<?php

namespace GameAPIs\Controllers\Documentation\BF2142;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Battlefield 2142 Documentation - ');
    }

}
