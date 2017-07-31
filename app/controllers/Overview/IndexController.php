<?php

namespace GameAPIs\Controllers\Overview;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle("GameAPIs");
    }

    public function indexAction() {
        $this->tag->prependTitle("Index - ");
        $this->response->redirect("/docs/");
    }

    public function notfoundAction() {
        $this->tag->prependTitle("404 - ");
    }

}
