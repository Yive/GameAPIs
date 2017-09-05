<?php

namespace GameAPIs\Controllers\Documentation\DNL;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Dark and Light Documentation - ');
    }

}
