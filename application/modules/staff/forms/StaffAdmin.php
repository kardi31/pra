<?php

/**
 * News_Form_News
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Staff_Form_StaffAdmin extends Admin_Form {
    
    public function init() {
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        
        $firstname = $this->createElement('text', 'firstname');
        $firstname->setLabel('First name');
        $firstname->setDecorators(self::$textAdminDecorators);
        $firstname->setAttrib('class', 'form-control');
        
        $lastname = $this->createElement('text', 'lastname');
        $lastname->setLabel('Last name');
        $lastname->setDecorators(self::$textAdminDecorators);
        $lastname->setAttrib('class', 'form-control');
        
        
        
        $position = $this->createElement('text', 'position');
        $position->setLabel('Position in company');
        $position->setDecorators(self::$textAdminDecorators);
        $position->setAttrib('class', 'form-control');
        
        $email = $this->createElement('text', 'email');
        $email->setLabel('Email');
        $email->setDecorators(self::$textAdminDecorators);
        $email->setAttrib('class', 'form-control');
        
        $branchId = $this->createElement('select', 'branch_id');
        $branchId->setLabel('Branch');
        $branchId->setDecorators(self::$selectAdminDecorators);
        $branchId->setAttrib('class', 'form-control');
        
        
        $languages = $i18nService->getLanguageList();
        
        $translations = new Zend_Form_SubForm();
        
        foreach($languages as $language) {
            $translationForm = new Zend_Form_SubForm();
            $translationForm->setName($language);
            $translationForm->setDecorators(array(
                'FormElements'
            ));
            
            $description = $translationForm->createElement('textarea', 'description');
            $description->setBelongsTo($language);
            $description->setLabel('Description');
            $description->setRequired(false);
            $description->setDecorators(self::$tinymceDecorators);
            $description->setAttrib('class', 'span8 tinymce');
            
            $translationForm->setElements(array(
                $description
            ));

            $translations->addSubForm($translationForm, $language);
        }
        
        $this->addSubForm($translations, 'translations');
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(self::$submitDecorators);
//        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));

        $this->setElements(array(
            $id,
            $firstname,
            $email,
            $lastname,
            $branchId,
            $position,
            $submit
        ));
    }
}

