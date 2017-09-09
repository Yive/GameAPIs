<?php

namespace GameAPIs\Controllers\Documentation\CODUO;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Call of Duty: United Offensive Documentation - ');
    }

}
