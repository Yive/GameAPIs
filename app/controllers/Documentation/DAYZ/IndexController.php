<?php

namespace GameAPIs\Controllers\Documentation\DAYZ;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('DayZ Standalone Documentation - ');
    }

}
