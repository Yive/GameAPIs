<?php

namespace GameAPIs\Controllers\Documentation;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle("GameAPIs");
    }

    public function indexAction() {
        $this->tag->prependTitle("Documentation - ");
    }

    public function voiceAction() {
        $this->tag->prependTitle("Documentation - ");
    }

    public function otherAction() {
        $this->tag->prependTitle("Documentation - ");
    }

}
