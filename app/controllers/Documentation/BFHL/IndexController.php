<?php

namespace GameAPIs\Controllers\Documentation\BFHL;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Battlefield: Hardline Documentation - ');
    }

}
