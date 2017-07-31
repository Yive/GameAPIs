<?php

namespace GameAPIs\Controllers\Documentation\SD2D;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('7 Days to Die Documentation - ');
    }

}
