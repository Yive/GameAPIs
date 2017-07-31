<?php

namespace GameAPIs\Controllers\Documentation\AlienSwarm;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Alien Swarm Documentation - ');
    }

}
