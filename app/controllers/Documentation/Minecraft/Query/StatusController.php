<?php

namespace GameAPIs\Controllers\Documentation\Minecraft\Query;

class StatusController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle("GameAPIs");
    }

    public function indexAction() {
        $this->tag->prependTitle("Minecraft Server Query API - ");
    }

}
