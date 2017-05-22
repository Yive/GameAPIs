<?php

namespace GameAPIs\Controllers\Documentation\Minecraft\Query;

class MinecraftController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle("GameAPIs");
    }

    public function indexAction() {
        $this->tag->prependTitle("Minecraft APIs - ");
        return $this->response->redirect("supported/minecraft");
    }

    public function queryAction() {
        $this->tag->prependTitle("Minecraft Server Query API - ");
    }

    public function playerAction() {
        $this->tag->prependTitle("Minecraft Player Images API - ");
    }

    public function ecommerceAction() {
        $this->tag->prependTitle("Minecraft Server Ecommerce API - ");
    }

    public function extraAction() {
        $this->tag->prependTitle("Minecraft Extra APIs - ");
    }

}
