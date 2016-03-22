<?php

/**
 * Slider_Form_Layer
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Review_Form_ReviewAdmin extends Admin_Form {
    
    
    public function init()
    {
        
        $aid = $this->createElement('hidden','agent_id');
        
        
        $hostname = $this->createElement('text','hostname');
        $hostname->setLabel('Hostname');
        $hostname->setDecorators(self::$textDecorators);
        $hostname->setAttrib('class','form-control');
        
        $ip = $this->createElement('text','ip');
        $ip->setLabel('IP');
        $ip->setDecorators(self::$textDecorators);
        $ip->setAttrib('class','form-control');
        
        $activation_hostname = $this->createElement('text','activation_hostname');
        $activation_hostname->setLabel('Activation hostname');
        $activation_hostname->setDecorators(self::$textDecorators);
        $activation_hostname->setAttrib('class','form-control');
        
        $activation_ip = $this->createElement('text','activation_ip');
        $activation_ip->setLabel('Activation ip');
        $activation_ip->setDecorators(self::$textDecorators);
        $activation_ip->setAttrib('class','form-control');
        
        
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        $rating = $this->createElement('select','rating');
        $rating->setRequired(true);
        $rating->setLabel('Ocena');
        $rating->setDecorators(self::$selectDecorators);
        $rating->addMultiOptions(range(1,5));
        
        
        $selectbranch = $this->createElement('select','branch_id');
        $selectbranch->setLabel('Oddział');
        $selectbranch->setDecorators(self::$selectDecorators);
        $selectbranch->addMultiOption('','No branch selected');
        $selectbranch->setAttrib('class','form-control');
        
         $languages = $i18nService->getLanguageList();
//
        $translations = new Zend_Form_SubForm();

        foreach($languages as $language) {
            $translationForm = new Zend_Form_SubForm();
            $translationForm->setName($language);
            $translationForm->setDecorators(array(
                'FormElements'
            ));
            
            
            $review = $translationForm->createElement('textarea', 'review');
            $review->setBelongsTo($language);
            $review->setLabel('Opinia');
            $review->setRequired(false);
            $review->setAttrib('rows',4);
            $review->setDecorators(self::$tinymceDecorators);
            $review->setAttrib('class', 'span8 tinymce');
            
             $feedback = $translationForm->createElement('textarea', 'feedback');
            $feedback->setBelongsTo($language);
            $feedback->setLabel('Feedback');
            $feedback->setRequired(false);
            $feedback->setDecorators(self::$tinymceDecorators);
            $feedback->setAttrib('class', 'span8 tinymce');
            $feedback->setAttrib('rows',10);
            
            $translationForm->setElements(array(
                $review,
                $feedback
            ));

            $translations->addSubForm($translationForm, $language);
        }
        
        $this->addSubForm($translations, 'translations');
        
        $name = $this->createElement('text','display_name');
        $name->setLabel('Wyświetlana nazwa');
        $name->setDecorators(self::$textDecorators);
        $name->setAttrib('class','form-control');
        
        $firstname = $this->createElement('text','firstname');
        $firstname->setLabel('Imie');
        $firstname->setDecorators(self::$textDecorators);
        $firstname->setAttrib('class','form-control');
        
        $service_date = $this->createElement('text','service_date');
        $service_date->setLabel('Data usługi');
        $service_date->setDecorators(self::$textDecorators);
        $service_date->setAttrib('class','form-control');
        
        
        $lastname = $this->createElement('text','lastname');
        $lastname->setLabel('Nazwisko');
        $lastname->setDecorators(self::$textDecorators);
        $lastname->setAttrib('class','form-control');

        $email = $this->createElement('text','email');
        $email->setLabel('Email');
        $email->setDecorators(self::$textDecorators);
        $email->setAttrib('class','form-control');
        
        $phone = $this->createElement('text','phone');
        $phone->setLabel('Telefon');
        $phone->setDecorators(self::$textDecorators);
        $phone->setAttrib('class','form-control');
        
        $willreturn = $this->createElement('radio','recommend');
        $willreturn->addMultiOption(1,'Yes');
        $willreturn->addMultiOption(0,'No')
                ->setSeparator('')->setRequired(true)
                ;
        $willreturn->setLabel('Polecane?');
        $willreturn->setDecorators(self::$checkboxDecorators);
        $willreturn->setAttrib('class','form-control');
        
      
        
        
        
        
        $staff1 = $this->createElement('select', 'staff1');
        $staff1->setLabel('Pracownik 1');
        $staff1->setDecorators(self::$selectDecorators);
        
        $staff2 = $this->createElement('select', 'staff2');
        $staff2->setLabel('Pracownik 2');
        $staff2->setDecorators(self::$selectDecorators);
        
        
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-success margtop20', 'type' => 'submit'));
        
        $this->addElements(
                array(
                    $aid,
                    $rating,
                    $hostname,
                    $ip,
                    $activation_hostname,
                    $activation_ip,
                    $email,
                    $service_date,
                    $name,
                    $selectbranch,
                    $firstname,
                    $lastname,
                    $willreturn,
                    $staff1,
                    $staff2,
                    $phone,
                    $submit
                ));
    }
}

