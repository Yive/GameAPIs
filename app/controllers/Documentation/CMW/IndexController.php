<?php

namespace GameAPIs\Controllers\Documentation\CMW;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Chivalry: Medieval Warfare Documentation - ');
    }

}
