<?php

class Application_Controller_Action_Helper_LoginRedirect extends Zend_Controller_Action_Helper_Abstract {
    // don't try to redirect to urls in this list
    private $_no_redirects = array(
        '/',
        '/user/login',
        '/user/logout',
        '/qrcodes',
    );
    /**
     * called by controllers if you need a way to redirect logged out users
     */
    public function direct() {
        $returnUrl = $this->getRequest()->getRequestUri();

        $url = '/user/login';
        if (!in_array($returnUrl, $this->_no_redirects)) {
            // append url for redirecting after sucessful login
            $url .= '?returnUrl=' . urlencode($returnUrl);
        }

        $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
        $redirector->gotoUrl($url);
    }
}
