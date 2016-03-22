<?php

/**
 * Advertisment_Form_Article
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Advertisment_Form_Advertisment extends Admin_Form {
    
    public function init() {
        
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        $photos = $this->createElement('hidden', 'photos');
        $photos->setIsArray(true);
                
        $town = $this->createElement('text', 'town');
        $town->setLabel('Town');
        $town->setRequired();
        $town->setDecorators(self::$mainTextDecorators);
        $town->setAttrib('class', 'form-control');
             
        $street = $this->createElement('text', 'street');
        $street->setLabel('Address');
        $street->setDecorators(self::$mainTextDecorators);
        $street->setAttrib('class', 'form-control');
                
        $postcode = $this->createElement('text', 'postcode');
        $postcode->setLabel('Postcode');
        $postcode->setRequired();
        $postcode->setDecorators(self::$mainTextDecorators);
        $postcode->setAttrib('class', 'form-control');
                
        $price = $this->createElement('text', 'price');
        $price->setLabel('Price');
        $price->setDecorators(self::$mainTextDecorators);
        $price->setAttrib('class', 'form-control');        
        
        $title = $this->createElement('text', 'title');
        $title->setLabel('Title');
        $title->setRequired();
        $title->setDecorators(self::$mainTextDecorators);
        $title->setAttrib('class', 'form-control');

        $content = $this->createElement('textarea', 'content');
        $content->setLabel('Content');
        $content->setRequired();
        $content->setDecorators(self::$mainTextareaDecorators);
        $content->setAttrib('class', 'form-control tinymce');
        $content->setAttrib('rows',4);

        $finish_date = $this->createElement('select', 'finish_date');
        $finish_date->setLabel('Length of ad display');
        $finish_date->setAttrib('class','form-control');
        $finish_date->setRequired();
        $finish_date->setDecorators(self::$mainSelectDecorators);
        
        $translator = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n')->getServiceBroker()->get('Zend_Translate');
        
        $options = array(
            '1-week' => '1 '.$translator->translate('week'),
            '2-weeks' => '2 '.$translator->translate('weeks'),
            '3-weeks' => '3 '.$translator->translate('weeks'),
            '4-weeks' => '4 '.$translator->translate('weeks'),
            '5-weeks' => '5 '.$translator->translate('weeks'),
            '6-weeks' => '6 '.$translator->translate('weeks'),
            '7-weeks' => '7 '.$translator->translate('weeks'),
            '8-weeks' => '8 '.$translator->translate('weeks'),
        );
        $finish_date->addMultiOptions($options);
        

        $name = $this->createElement('text', 'name');
        $name->setLabel('Your name');
        $name->setRequired();
        $name->setDecorators(self::$mainTextDecorators);
        $name->setAttrib('class', 'form-control');
        
        $phone = $this->createElement('text', 'phone');
        $phone->setLabel('Your phone');
        $phone->setDecorators(self::$mainTextDecorators);
        $phone->setAttrib('class', 'form-control');
        
        $email = $this->createElement('text', 'email');
        $email->setLabel('Your email');
        $email->setRequired();
        $email->setDecorators(self::$mainTextDecorators);
        $email->setAttrib('class', 'form-control');
        
//        
//        $publish = $this->createElement('checkbox', 'publish');
//        $publish->setLabel('Publish');
//        $publish->setDecorators(self::$checkgroupDecorators);
//        $publish->setAttrib('class', 'form-control');
//        
//        $publishDate = $this->createElement('text', 'publish_date');
//        $publishDate->setLabel('Publish date');
//        $publishDate->setDecorators(self::$datepickerDecorators);
//        $publishDate->setAttrib('class', 'form-control');
        
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel('Add advertisment');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-success', 'type' => 'submit'));

        $this->setElements(array(
            $id,
            $town,
            $postcode,
            $street,
            $photos,
            $price,$title,$content,$email,$phone,$name,$finish_date,
            $submit
        ));
    }
}

