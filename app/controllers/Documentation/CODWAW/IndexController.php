<?php

namespace GameAPIs\Controllers\Documentation\CODWAW;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Call of Duty: World at War Documentation - ');
    }

}
