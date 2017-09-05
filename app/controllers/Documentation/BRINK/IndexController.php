<?php

namespace GameAPIs\Controllers\Documentation\BRINK;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('BRINK Documentation - ');
    }

}
