<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initRouterTranslator() {
        $translator = new Zend_Translate(array('adapter' => 'tmx', 'content' => APPLICATION_PATH . '/configs/translations/router.tmx', 'locale' => 'en'));
        Zend_Controller_Router_Route::setDefaultTranslator($translator);
    }
    
    protected function _initFormTranslator() {
        $translator = $this->bootstrap('translate')->getResource('translate');
        Zend_Form::setDefaultTranslator($translator);
    }
    
	
}

