<?php

namespace GameAPIs\Controllers\Documentation\COD4;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Call of Duty 4 Documentation - ');
    }

}
