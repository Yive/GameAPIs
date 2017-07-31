<?php

namespace GameAPIs\Controllers\Overview;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle("GameAPIs");
    }

    public function indexAction() {
        $this->tag->prependTitle("Index - ");
        return $this->response->redirect('https://docs.gameapis.net/', true);
    }

    public function notfoundAction() {
        $this->tag->prependTitle("404 - ");
    }

}
