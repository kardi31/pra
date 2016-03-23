<?php

/**
 * Bootstrap
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Branch_Bootstrap extends Zend_Application_Module_Bootstrap {
    
    protected function _initModuleAutoloader() {
        $autoloader = new Zend_Application_Module_Autoloader(array(
            'basePath' => APPLICATION_PATH . '/modules/branch',
            'namespace' => '',
            'resourceTypes' => array(
                'library' => array(
                    'path' => 'library/',
                    'namespace' => 'Branch'
                )
            )
        ));
    }
    
    protected function _initModel() {
        Doctrine_Core::loadModels(APPLICATION_PATH . '/modules/branch/models/Doctrine', Doctrine_Core::MODEL_LOADING_CONSERVATIVE, $this->getModuleName() . '_Model_Doctrine_');
    }
	
}
