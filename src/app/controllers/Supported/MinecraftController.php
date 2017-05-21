<?php

namespace GameAPIs\Controllers\Supported;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle("GameAPIs");
    }

    public function indexAction() {
        $this->tag->prependTitle("Minecraft APIs - ");
    }

    public function queryAction() {
        $this->tag->prependTitle("Minecraft Server Query API - ");
    }

}
