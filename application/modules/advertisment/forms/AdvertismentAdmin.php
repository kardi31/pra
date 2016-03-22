<?php

/**
 * Advertisment_Form_Article
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Advertisment_Form_AdvertismentAdmin extends Admin_Form {
    
    public function init() {
        
        
        
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        $photos = $this->createElement('hidden', 'photos');
        $photos->setIsArray(true);
                
        $town = $this->createElement('text', 'town');
        $town->setLabel('Miasto');
        $town->setRequired();
        $town->setDecorators(self::$textDecorators);
        $town->setAttrib('class', 'col-md-8');
             
        $street = $this->createElement('text', 'street');
        $street->setLabel('Adres');
        $street->setDecorators(self::$textDecorators);
        $street->setAttrib('class', 'col-md-8');
                
        $postcode = $this->createElement('text', 'postcode');
        $postcode->setLabel('Kod pocztowy');
        $postcode->setRequired();
        $postcode->setDecorators(self::$textDecorators);
        $postcode->setAttrib('class', 'col-md-8');
                
        $price = $this->createElement('text', 'price');
        $price->setLabel('Cena');
        $price->setDecorators(self::$textDecorators);
        $price->setAttrib('class', 'col-md-8');        
        
       $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        
        
        $languages = $i18nService->getLanguageList();
        
        $translations = new Zend_Form_SubForm();

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
            $title->setAttrib('class', 'span8');

            $content = $translationForm->createElement('textarea', 'content');
            $content->setBelongsTo($language);
            $content->setLabel('Content');
            $content->setDecorators(self::$tinymceDecorators);

            $translationForm->setElements(array(
                $title,
                $content
            ));

            $translations->addSubForm($translationForm, $language);
        }

        $this->addSubForm($translations, 'translations');

        $finish_date = $this->createElement('text', 'finish_date');
        $finish_date->setLabel('Długość wyświetlania ogłoszenia');
        $finish_date->setAttrib('class','form-control');
        $finish_date->setRequired();
        $finish_date->setDecorators(self::$selectDecorators);
        
        
        $category_id = $this->createElement('select', 'category_id');
        $category_id->setLabel('Kategoria');
        $category_id->setAttrib('class','form-control');
        $category_id->setRequired();
        $category_id->setDecorators(self::$selectDecorators);
        
        

        $name = $this->createElement('text', 'name');
        $name->setLabel('Twoje imie');
        $name->setRequired();
        $name->setDecorators(self::$textDecorators);
        $name->setAttrib('class', 'col-md-8');
        
        $phone = $this->createElement('text', 'phone');
        $phone->setLabel('Twój telefon');
        $phone->setDecorators(self::$textDecorators);
        $phone->setAttrib('class', 'col-md-8');
        
        $email = $this->createElement('text', 'email');
        $email->setLabel('Twój email');
        $email->setRequired();
        $email->setDecorators(self::$textDecorators);
        $email->setAttrib('class', 'col-md-8');
        
//        
        $publish = $this->createElement('checkbox', 'publish');
        $publish->setLabel('Publish');
        $publish->setDecorators(self::$checkgroupDecorators);
        $publish->setAttrib('class', 'col-md-8');
//        
//        $publishDate = $this->createElement('text', 'publish_date');
//        $publishDate->setLabel('Publish date');
//        $publishDate->setDecorators(self::$datepickerDecorators);
//        $publishDate->setAttrib('class', 'col-md-8');
        
        $submit = $this->createElement('submit', 'submit');
        $submit->setLabel('Dodaj ogłoszenie');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-success', 'type' => 'submit'));

        $this->setElements(array(
            $id,
            $town,
            $postcode,
            $street,
            $publish,$category_id,
            $photos,
            $price,$email,$phone,$name,$finish_date,
            $submit
        ));
    }
}

