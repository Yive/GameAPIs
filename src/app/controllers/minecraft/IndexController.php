<?php

namespace GameAPIs\Controllers\Minecraft;

class SupportedController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle("GameAPIs");
    }

    public function indexAction() {

    }

    public function minecraftAction() {
        $this->tag->prependTitle("Minecraft APIs - ");
    }

}
