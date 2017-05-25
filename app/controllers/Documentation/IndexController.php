<?php

namespace GameAPIs\Controllers\Documentation;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle("GameAPIs");
    }

    public function indexAction() {
        $this->tag->prependTitle("Test - ");
        echo "string";
    }

    public function minecraftAction() {
        $this->tag->prependTitle("Minecraft APIs - ");
    }

}
