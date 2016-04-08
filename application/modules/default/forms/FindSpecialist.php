<?php

/**
 * Contact
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Default_Form_FindSpecialist extends Admin_Form {
    
   
    public function init() {
        $view = $this->getView();
        $translator = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n')->getServiceBroker()->get('Zend_Translate');
        
        $name = $this->createElement('text', 'name');
        $name->setLabel('Your full name');
        $name->setRequired(true);
        $name->setDecorators(self::$textAdminDecorators);
        $name->setAttrib('class', 'form-control');
        if($view->language=='pl'){
            $name->setAttrib('placeholder', 'np. Jan Kowalski');
        }
        else{
            $name->setAttrib('placeholder', 'e.g. Mark Smith');
        }
                
        
        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Your email');
        $email->setRequired(true);
        $email->setDecorators(self::$textAdminDecorators);
        $email->setAttrib('class', 'form-control');
        if($view->language=='pl'){
            $email->setAttrib('placeholder', 'np. johnsmith@yahoo.com');
        }
        else{
            $email->setAttrib('placeholder', 'e.g. johnsmith@yahoo.com');
        }
        
        
        $phone = $this->createElement('text','phone');
        $phone->setLabel('Your phone');
        $phone->setDecorators(self::$textAdminDecorators);
        $phone->setAttrib('class', 'form-control');
        if($view->language=='pl'){
            $phone->setAttrib('placeholder', 'np. 555 1123 451');
        }
        else{
            $phone->setAttrib('placeholder', 'e.g. 555 1123 451');
        }
        
        $address = $this->createElement('text','address');
        $address->setLabel('Your address');
        $address->setDecorators(self::$textAdminDecorators);
        $address->setAttrib('class', 'form-control');
        if($view->language=='pl'){
            $address->setAttrib('placeholder', 'np. ul. Jaśminowa 53');
        }
        else{
            $address->setAttrib('placeholder', 'e.g. 23 London Road');
        }
        
        $town = $this->createElement('text','town');
        $town->setLabel('Town');
        $town->setRequired();
        $town->setDecorators(self::$textAdminDecorators);
        $town->setAttrib('class', 'form-control');
        if($view->language=='pl'){
            $town->setAttrib('placeholder', 'np. Warszawa');
        }
        else{
            $town->setAttrib('placeholder', 'e.g. Liverpool');
        }
        
        $postcode = $this->createElement('text','postcode');
        $postcode->setLabel('Postcode');
        $postcode->setDecorators(self::$textAdminDecorators);
        $postcode->setAttrib('class', 'form-control');
        $postcode->setRequired();
        if($view->language=='pl'){
            $postcode->setAttrib('placeholder', 'np. 00-750');
        }
        else{
            $postcode->setAttrib('placeholder', 'e.g. Nw6 2QR');
        }
        
//        $subject = $this->createElement('text', 'subject');
//        $subject->setLabel('Title');
//        $subject->setRequired(true);
//        $subject->setDecorators(self::$textDecorators);
//        $subject->setAttrib('class', 'span8');
        
        
        $message = $this->createElement('textarea', 'message');
        $message->setLabel('Your message');
        $message->setRequired(true);
        $message->setDecorators(self::$textAdminDecorators);
        $message->setAttrib('class', 'form-control');
        $message->setAttrib('rows', '4');
        if($view->language=='pl'){
            $message->setAttrib('placeholder', 'Powiedz nam jakiego specjalisty szukasz.');
        }
        else{
            $message->setAttrib('placeholder', 'Please tell us what kind of specialist are you looking for?');
        }
        
        
        
          
       $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Wyślij');
        $submit->setDecorators(self::$submitDecorators);
        $submit->setAttribs(array('class' => 'btn-search', 'type' => 'submit'));
       
        $this->setElements(array(
            $name,
//            $surname,
            $email,
            $phone,
            $address,
            $town,
            $postcode,
//            $subject,
            $message,
            $submit
        ));
    }
}

