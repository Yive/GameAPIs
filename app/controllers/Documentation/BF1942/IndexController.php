<?php

namespace GameAPIs\Controllers\Documentation\BF1942;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Battlefield 1942 Documentation - ');
    }

}
