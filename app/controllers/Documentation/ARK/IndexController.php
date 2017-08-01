<?php

namespace GameAPIs\Controllers\Documentation\ARK;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('ARK: Survival Evolved Documentation - ');
    }

}
