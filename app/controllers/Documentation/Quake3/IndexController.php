<?php

namespace GameAPIs\Controllers\Documentation\Quake3;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Quake 3 Documentation - ');
    }

}
