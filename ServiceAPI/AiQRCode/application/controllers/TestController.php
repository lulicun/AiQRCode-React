<?php

class TestController extends BaseController {
    public function init() {
        parent::init();
    }

    public function fluxTodoAction() {
        $this->render('flux-todo');
    }

    public function helloWorldAction() {
        $this->render('hello-world');
    }
}
