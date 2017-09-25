<?php

namespace GameAPIs\Controllers\Documentation\ASE;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('All-Seeing Eye Documentation - ');
    }

}
