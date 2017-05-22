<?php

namespace GameAPIs\Controllers\Documentation\Minecraft;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('Minecraft APIs - ');
        return $this->response->redirect('docs/minecraft');
    }

    public function extraAction() {
        return $this->response->redirect("docs/minecraft/extra/index");
    }

    public function queryAction() {
        return $this->response->redirect("docs/minecraft/query/index");
    }

    public function imagesAction() {
        return $this->response->redirect("docs/minecraft/images/index");
    }

    public function ecommerceAction() {
        return $this->response->redirect("docs/minecraft/ecommerce/index");
    }

}
