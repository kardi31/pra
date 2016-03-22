<?php

/**
 * Slider_Form_Layer
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Review_Form_CommentAdmin extends Admin_Form {
    
    
    public function init()
    {
        
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
        
        
         $languages = $i18nService->getLanguageList();
        $translations = new Zend_Form_SubForm();

        foreach($languages as $language) {
            $translationForm = new Zend_Form_SubForm();
            $translationForm->setName($language);
            $translationForm->setDecorators(array(
                'FormElements'
            ));
            
            
            $comment = $translationForm->createElement('textarea', 'comment');
            $comment->setBelongsTo($language);
            $comment->setLabel('Komentarz');
            $comment->setRequired(false);
            $comment->setAttrib('rows',4);
            $comment->setDecorators(self::$tinymceDecorators);
            $comment->setAttrib('class', 'span8 tinymce');
            
            
            $translationForm->setElements(array(
                $comment
            ));

            $translations->addSubForm($translationForm, $language);
        }
        
        $this->addSubForm($translations, 'translations');
        
        $name = $this->createElement('text','name');
        $name->setLabel('Wyświetlana nazwa');
        $name->setDecorators(self::$textDecorators);
        $name->setAttrib('class','form-control');
        
        $email = $this->createElement('text','email');
        $email->setLabel('Email');
        $email->setDecorators(self::$textDecorators);
        $email->setAttrib('class','form-control');
        
        
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-success margtop20', 'type' => 'submit'));
        
        $this->addElements(
                array(
                    $hostname,
                    $ip,
                    $activation_hostname,
                    $activation_ip,
                    $email,
                    $name,
                    $submit
                ));
    }
}

