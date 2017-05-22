<?php

namespace GameAPIs\Controllers\APIs\Minecraft;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle("GameAPIs");
    }

    public function indexAction() {

    }

    public function minecraftAction() {
        $this->tag->prependTitle("Minecraft APIs - ");
    }

}
