<?php

namespace GameAPIs\Controllers\Documentation\CSGO;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Counter-Strike: Global Offensive Documentation - ');
    }

}
