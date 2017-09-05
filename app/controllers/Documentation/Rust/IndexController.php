<?php

namespace GameAPIs\Controllers\Documentation\Rust;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Rust Documentation - ');
    }

}
