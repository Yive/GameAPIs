<?php

namespace GameAPIs\Controllers\Documentation\GameSpy;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        return $this->response->redirect("docs/gamespy/1");
    }

    public function gamespyAction() {
        $this->tag->prependTitle("GameSpy Documentation - ");
    }

    public function gamespy2Action() {
        $this->tag->prependTitle("GameSpy 2 Documentation - ");
    }

    public function gamespy3Action() {
        $this->tag->prependTitle("GameSpy 3 Documentation - ");
    }

}
