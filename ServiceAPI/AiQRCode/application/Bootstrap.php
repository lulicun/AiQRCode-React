<?php

//Rewrite bootstrap method, the method start with _init will be execute
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
     /**
     * init memcache
     * @return Memcached
     */
    protected function _initMemcache() {
        global $memcache;
        return $memcache;
    }

    /**
     * Get configuration details
     *
     * @return Zend_Config
     */
    protected function _initConfig() {
        $memcache = $this->getResource('memcache');
        if (!$config = $memcache->get(APPLICATION_ENV . '-config')) {
            $config = new Zend_Config($this->getOptions(), true);
            $memcache->set(APPLICATION_ENV . '-config', $config);
        }
        Zend_Registry::set('config', $config);
        return $config;
    }

    /**
     * Initialise resources
     */
    protected function _initResourceAutoloader() {
        $autoloader = new Zend_Loader_Autoloader_Resource(array(
            'basePath' => APPLICATION_PATH,
            'namespace' => 'Application',
        ));

        $loader = Zend_Loader_Autoloader::getInstance();
        $loader->registerNamespace('AiQRCode_');
        $loader->setFallbackAutoloader(true);

        $autoloader->addResourceType('model', 'models', 'Model');
        $autoloader->addResourceType('form', 'forms', 'Form');
        $autoloader->addResourceType('job', 'jobs', 'Job');
        return $autoloader;
    }

    protected function _initResque() {
        Resque::setBackend($this->getResource('config')->get('redis')->get('host') . ':' .
            $this->getResource('config')->get('redis')->get('port'));
    }

    /**
     * initialize controller helper path
     */
    protected function _initHelperPath() {
        Zend_Controller_Action_HelperBroker::addPath(
            APPLICATION_PATH . '/controllers/helpers',
            'Application_Controller_Action_Helper_');
    }

     /**
     * init the session with gc_maxlifetime defined by ini
     */
    protected function _initSession() {
        $rememberMeSeconds = $this->getResource('config')->get('resources')->get('session')->get('remember_me_seconds');
        ini_set('session.gc_maxlifetime', $rememberMeSeconds);
    }

        /**
     * Initialize views
     */
    protected function _initView() {
        // don't init view on AJAX calls
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return;
        }

        // init view
        $view = new Zend_View();
        $view->doctype('XHTML1_STRICT');
        $view->headTitle('AiQRCode by Lulicun ');

        // init view vars
        $view->env = APPLICATION_ENV;

        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);

        return $view;
    }
}

