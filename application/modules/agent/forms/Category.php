<?php

class Agent_Form_Category extends Admin_Form
{
    public function init() {
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        
        $parentId = $this->createElement('hidden', 'parent_id');
        $parentId->setDecorators(array('ViewHelper'));
        
        
        $translations = new Zend_Form_SubForm();

        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            $translationForm = new Zend_Form_SubForm();
            $translationForm->setName($language);
            $translationForm->setDecorators(array(
                'FormElements'
            ));

            $title = $translationForm->createElement('text', 'title');
            $title->setBelongsTo($language);
            $title->setLabel('Title');
            $title->setDecorators(self::$textDecorators);
            $title->addValidators(array(
                array('regex', false, array('pattern' => '/[a-zA-Z0-9\&\/\.\,\-]+/'))
            ));
            $title->setAttrib('class', 'span8');
            
            $translationForm->setElements(array(
                $title,
            ));

            $translations->addSubForm($translationForm, $language);
        }

        $this->addSubForm($translations, 'translations');


        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));
        
        $this->setElements(array(
            $id,
            $parentId,
            $submit
        ));
    }
    
}

