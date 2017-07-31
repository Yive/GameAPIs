<?php

namespace GameAPIs\Controllers\Documentation\GMOD;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle("Garry's Mod Documentation - ");
    }

}
