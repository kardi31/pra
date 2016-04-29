<?php

/**
 * News_Form_News
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_Form_AgentAdmin extends Admin_Form {
    
    public function init() {
        $premium_support = $this->createElement('checkbox', 'premium_support');
        $premium_support->setLabel('Premium support');
        $premium_support->setDecorators(self::$checkboxDecorators);
        $premium_support->setAttrib('class', 'form-control');
        
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        $firstname = $this->createElement('text', 'firstname');
        $firstname->setLabel('First name');
        $firstname->setDecorators(self::$textDecorators);
        $firstname->setAttrib('class', 'form-control');
        
        $lastname = $this->createElement('text', 'lastname');
        $lastname->setLabel('Last name');
        $lastname->setDecorators(self::$textDecorators);
        $lastname->setAttrib('class', 'form-control');
        
        $email = $this->createElement('text', 'email');
        $email->setLabel('Email');
        $email->setDecorators(self::$textDecorators);
        $email->setAttrib('class', 'form-control');
        
        $name = $this->createElement('text', 'name');
        $name->setLabel('Company name');
        $name->setDecorators(self::$textDecorators);
        $name->setAttrib('class', 'form-control');
        
        $office_name = $this->createElement('text', 'office_name');
        $office_name->setLabel('Office name');
        $office_name->setDecorators(self::$textDecorators);
        $office_name->setAttrib('class', 'form-control');
        
        
        $description = $this->createElement('textarea', 'description');
        $description->setLabel('Description');
        $description->setDecorators(self::$textDecorators)
                ->setAttrib('rows',10)
                ;
        $description->setAttrib('class', 'form-control');
        
        $address = $this->createElement('text', 'address');
        $address->setLabel('Address');
        $address->setDecorators(self::$textDecorators);
        $address->setAttrib('class', 'form-control');
        
         $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        $languages = $i18nService->getLanguageList();

        $translations = new Zend_Form_SubForm();

        foreach($languages as $language) {
            $translationForm = new Zend_Form_SubForm();
            $translationForm->setName($language);
            $translationForm->setDecorators(array(
                'FormElements'
            ));

            $desc = $translationForm->createElement('textarea', 'description');
            $desc->setBelongsTo($language);
            $desc->setLabel('Opis');
            $desc->setAttrib('rows',5);
            $desc->setDecorators(self::$textDecorators);
            $desc->setAttrib('class', 'span8');
            
            $translationForm->setElements(array(
                $desc
            ));

            $translations->addSubForm($translationForm, $language);
        }

        $this->addSubForm($translations, 'translations');
        
        $category = $this->createElement('select', 'category_id');
        $category->setLabel('Categories');
//        $category->setDecorators(self::$selectDecorators);
        $category->setAttrib('class', 'form-control no-uniform nostyle select2');
        $category->setIsArray(true);
        $category->setAttrib('multiple','multiple');
        
        $town = $this->createElement('text', 'town');
        $town->setLabel('Town');
        $town->setDecorators(self::$textDecorators);
        $town->setAttrib('class', 'form-control');
        
        $county = $this->createElement('text', 'county');
        $county->setLabel('County');
        $county->setDecorators(self::$textDecorators);
        $county->setAttrib('class', 'form-control');
        
        $postcode = $this->createElement('text', 'postcode');
        $postcode->setLabel('Postcode');
        $postcode->setDecorators(self::$textDecorators);
        $postcode->setAttrib('class', 'form-control');
        
        $phone = $this->createElement('text', 'phone');
        $phone->setLabel('Phone');
        $phone->setDecorators(self::$textDecorators);
        $phone->setAttrib('class', 'form-control');
       
        $facebook = $this->createElement('text', 'facebook');
        $facebook->setLabel('Facebook');
        $facebook->setDecorators(self::$textDecorators);
        $facebook->setAttrib('class', 'form-control');
        
        $twitter = $this->createElement('text', 'twitter');
        $twitter->setLabel('Twitter');
        $twitter->setDecorators(self::$textDecorators);
        $twitter->setAttrib('class', 'form-control');
        
        
        
        $branch_email = $this->createElement('text', 'branch_email');
        $branch_email->setLabel('Email');
        $branch_email->setDecorators(self::$textDecorators);
        $branch_email->setAttrib('class', 'form-control');
        
        $agent_email = $this->createElement('text', 'agent_email');
        $agent_email->setLabel('Email');
        $agent_email->setDecorators(self::$textDecorators);
        $agent_email->setAttrib('class', 'form-control');
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(self::$submitDecorators);
//        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));

        $this->setElements(array(
            $id,
            $firstname,
            $lastname,
            $email,
            $name,
            $category,
            $branch_email,
            $agent_email,
            $description,
            $address,
            $office_name,
            $town,
            $county,
            $postcode,
            $premium_support,
            $phone,
            $facebook,
            $twitter,
            $submit
        ));
        
        $this->setElementFilters(array('StringTrim'));
    }
}

