<?php

namespace GameAPIs\Controllers\Documentation\CSS;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Counter-Strike: Source Documentation - ');
    }

}
