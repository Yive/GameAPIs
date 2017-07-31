<?php

namespace GameAPIs\Controllers\Documentation\Minecraft;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        return $this->response->redirect("docs/mc/query");
    }

    public function extraAction() {
        $this->tag->prependTitle("Minecraft Extra Documentation - ");
    }

    public function queryAction() {
        $this->tag->prependTitle("Minecraft Query Documentation - ");
    }

    public function imagesAction() {
        $this->tag->prependTitle("Minecraft Images Documentation - ");
    }

    public function ecommerceAction() {
        $this->tag->prependTitle("Minecraft Ecommerce Documentation - ");
    }

    public function mcpeAction() {
        $this->tag->prependTitle("Minecraft: Pocket Edition Documentation - ");
    }

}
