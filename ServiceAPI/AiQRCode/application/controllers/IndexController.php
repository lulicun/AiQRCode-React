<?php

class IndexController extends BaseController {
    public function init() {
        parent::init();
        if ($this->isLoggedIn()) {
            return $this->_redirect('qrcodes');
        } else {
            return $this->loginRedirect();
        }
    }
}
