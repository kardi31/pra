<?php

/**
 * News_Form_News
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_Form_BranchAdmin extends Admin_Form {
    
    public function init() {
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        $agent_id = $this->createElement('hidden', 'agent_id');
        $agent_id->setDecorators(array('ViewHelper'));
        
        $office_name = $this->createElement('text', 'office_name');
        $office_name->setLabel('Office name');
        $office_name->setDecorators(self::$textDecorators);
        $office_name->setAttrib('class', 'form-control');
        
        $address = $this->createElement('text', 'address');
        $address->setLabel('Address');
        $address->setDecorators(self::$textDecorators);
        $address->setAttrib('class', 'form-control');
        
        
        $view = $this->createElement('checkbox', 'view');
        $view->setLabel('View');
        $view->setDecorators(self::$checkboxDecorators);
        
        $approved = $this->createElement('checkbox', 'approved');
        $approved->setLabel('Approved');
        $approved->setDecorators(self::$checkgroupDecorators);
        
        $premium_support = $this->createElement('checkbox', 'premium_support');
        $premium_support->setLabel('Premium support');
        $premium_support->setDecorators(self::$checkgroupDecorators);
        
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
       
        $url = $this->createElement('text', 'url');
        $url->setLabel('Website');
        $url->setDecorators(self::$textDecorators);
        $url->setAttrib('class', 'form-control');
        
        $facebook = $this->createElement('text', 'facebook');
        $facebook->setLabel('Facebook');
        $facebook->setDecorators(self::$textDecorators);
        $facebook->setAttrib('class', 'form-control');
        
        $twitter = $this->createElement('text', 'twitter');
        $twitter->setLabel('Twitter');
        $twitter->setDecorators(self::$textDecorators);
        $twitter->setAttrib('class', 'form-control');
        
        $lat = $this->createElement('text', 'lat');
        $lat->setLabel('Lat');
        $lat->setDecorators(self::$textDecorators);
        $lat->setAttrib('class', 'form-control');
        
        $lng = $this->createElement('text', 'lng');
        $lng->setLabel('Lng');
        $lng->setDecorators(self::$textDecorators);
        $lng->setAttrib('class', 'form-control');
        
         $languages = $i18nService->getLanguageList();
//
        $translations = new Zend_Form_SubForm();

        foreach($languages as $language) {
            $translationForm = new Zend_Form_SubForm();
            $translationForm->setName($language);
            $translationForm->setDecorators(array(
                'FormElements'
            ));
            
//            $name = $translationForm->createElement('text', 'name');
//            $name->setBelongsTo($language);
//            $name->setLabel('Video name');
//            $name->setDecorators(self::$textDecorators);
//            $name->setAttrib('class', 'span8');
            
            $description = $translationForm->createElement('textarea', 'description');
            $description->setBelongsTo($language);
            $description->setLabel('Description');
            $description->setRequired(false);
            $description->setDecorators(self::$tinymceDecorators);
            $description->setAttrib('class', 'span8 tinymce');
            
            $translationForm->setElements(array(
//                $name,
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
            $address,
            $office_name,
            $town,
            $premium_support,
            $view,
            $county,
            $postcode,
            $approved,
            $agent_id,
            $phone,
            $url,
            $facebook,
            $twitter,
            $lat,
            $lng,
            $submit
        ));
    }
}

