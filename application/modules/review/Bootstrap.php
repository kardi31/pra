<?php

/**
 * Bootstrap
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Review_Bootstrap extends Zend_Application_Module_Bootstrap {
    
    protected function _initModel() {
        Doctrine_Core::loadModels(APPLICATION_PATH . '/modules/review/models/Doctrine', Doctrine_Core::MODEL_LOADING_CONSERVATIVE, $this->getModuleName() . '_Model_Doctrine_');
    }
	
    protected function _initModuleAutoloader() {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'basePath' => APPLICATION_PATH . '/modules/review',
            'namespace' => '',
            'resourceTypes' => array(
                'library' => array(
                    'path' => 'library/',
                    'namespace' => 'Review'
                )
            )
        ));
    }
    
//    protected function _initSliders() {
//        $sliders = array(
//            'main' => 'Main slider',
//            'second' => 'Second slider'
//        );
//        $this->getApplication()->getContainer()->set('sliders', $sliders);
//        
//        $sliderHelper = new Slider_View_Helper_Slider();
//        $view = $this->getApplication()->bootstrap('view')->getResource('view');
//        $view->registerHelper($sliderHelper, 'slider');
//    }
    
}

