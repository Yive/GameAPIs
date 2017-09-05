<?php

namespace GameAPIs\Controllers\Documentation\CE;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Conan Exiles Documentation - ');
    }

}
