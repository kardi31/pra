<?php

/**
 * News_Form_News
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_Form_Contact extends Admin_Form {
    
    public function init() {
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        $firstname = $this->createElement('text', 'firstname');
        $firstname->setLabel('First name');
        $firstname->setRequired();
        $firstname->setDecorators(self::$textAdminDecorators);
        $firstname->setAttrib('class', 'form-control');
        
        $lastname = $this->createElement('text', 'lastname');
        $lastname->setLabel('Last name');
        $lastname->setRequired();
        $lastname->setDecorators(self::$textAdminDecorators);
        $lastname->setAttrib('class', 'form-control');
        
        $email = $this->createElement('text', 'email');
        $email->setLabel('Email');
        $email->setRequired();
        $email->setDecorators(self::$textAdminDecorators);
        $email->setAttrib('class', 'form-control');
        
        $phone = $this->createElement('text', 'phone');
        $phone->setLabel('Phone');
        $phone->setDecorators(self::$textAdminDecorators);
        $phone->setAttrib('class', 'form-control');
        
        $branch = $this->createElement('select', 'branch_id');
        $branch->setLabel('Oddział');
        $branch->setRequired();
        $branch->setDecorators(self::$textAdminDecorators);
        $branch->setAttrib('class', 'form-control');
        
        $message = $this->createElement('textarea', 'message');
        $message->setLabel('Message');
        $message->setRequired();
        $message->setDecorators(self::$textAdminDecorators);
        $message->setAttrib('class', 'form-control');
        $message->setAttrib('rows', 5);
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Send message');
        $submit->setDecorators(self::$submitDecorators);
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));

        $this->setElements(array(
            $id,
            $firstname,
            $lastname,
            $branch,
            $email,
            $phone,
            $message,
            $submit
        ));
    }
}

