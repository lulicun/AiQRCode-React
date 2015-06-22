<?php

class UserController extends BaseController {

    public function init() {
        parent::init();
    }

    public function IndexAction() {
        echo "user/index";
        die();
    }

    /**
     * User login
     */
    public function loginAction() {
        try {
            // Title for user login page
            $this->view->title = 'Login';
            $this->render('login');
        } catch (Exception $strException) {
            /*
             *  Handle the exception
             */
            $this->view->strExceptionMessage = $strException->getMessage() . PHP_EOL . $strException->getTraceAsString();
        }
    }
}
