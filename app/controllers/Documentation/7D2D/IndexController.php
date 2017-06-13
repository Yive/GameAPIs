<?php

namespace GameAPIs\Controllers\Documentation\SD2D;

class IndexController extends ControllerBase {

    public function initialize() {
        $this->tag->setTitle('GameAPIs');
    }

    public function indexAction() {
        $this->tag->prependTitle('7 Days To Die Documentation - ');
    }

    public function extraAction() {
        return $this->response->redirect("docs/7d2d/extra/index");
    }

    public function queryAction() {
        return $this->response->redirect("docs/7d2d/query/index");
    }

    public function imagesAction() {
        return $this->response->redirect("docs/7d2d/images/index");
    }

    public function ecommerceAction() {
        return $this->response->redirect("docs/7d2d/ecommerce/index");
    }

}
