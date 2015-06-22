<?php

/**
 *	TODO:
 *		Initialize session ...
 **/

class BaseController extends Zend_Controller_Action {

    public $_session;

    public function init() {
        parent::init();
        // init session handler
        $this->_initSession();
        // create session
        if (Zend_Session::sessionExists()) {
            $this->setSession();
        }
		//TODO: ... Initialize
	}

    protected function _initSession() {
        $db = AiQRCode_Dbo::getDb();
        $session_collection = $db->session;
        Zend_Session::setSaveHandler(new AiQRCode_MongoSession($session_collection));
    }

    protected function getSession() {
        if (!$this->_session) {
            $this->setSession();
        }
        return $this->_session;
    }

    protected function setSession() {
        if (!$this->_session) {
            $this->_session = new Zend_Session_Namespace('AiQRCode');
        }
    }

    /**
     * check if this is a logged in session
     * @return boolean true if logged in, false otherwise
     */
    public function isLoggedIn() {
        if (Zend_Session::sessionExists()) {
            if ($this->getSession()->userId) {
                return true;
            }
        }
        return false;
    }

    public function loginRedirect() {
        echo "loginRedirect";
        $this->_helper->loginRedirect();
    }


    protected function disableView() {
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

}
