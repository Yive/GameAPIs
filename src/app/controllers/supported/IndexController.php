<?php

class SupportedController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle("GameAPIs");
    }

    public function indexAction() {

    }

    public function minecraftAction() {
        $this->tag->prependTitle("Minecraft APIs - ");
    }

    public function minecraftpeAction() {
        $this->tag->prependTitle("MinecraftPE APIs - ");
    }

}
