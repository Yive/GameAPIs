<?php

namespace GameAPIs\Controllers\Documentation\Quake2;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Quake 2 Documentation - ');
    }

}
