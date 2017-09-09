<?php

namespace GameAPIs\Controllers\Documentation\Source;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Source Documentation - ');
    }

}
