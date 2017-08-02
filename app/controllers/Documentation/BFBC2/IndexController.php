<?php

namespace GameAPIs\Controllers\Documentation\BFBC2;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Battlefield: Bad Company 2 Documentation - ');
    }

}
