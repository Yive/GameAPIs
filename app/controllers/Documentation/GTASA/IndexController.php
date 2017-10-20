<?php

namespace GameAPIs\Controllers\Documentation\GTASA;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Grand Theft Auto: San Andreas Documentation - ');
    }

    public function mtaAction() {
        $this->tag->prependTitle('Multi Theft Auto Documentation - ');
    }

    public function sampAction() {
        $this->tag->prependTitle('San Andreas Multiplayer Documentation - ');
    }

}
