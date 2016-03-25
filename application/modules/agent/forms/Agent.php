<?php

/**
 * News_Form_News
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_Form_Agent extends Admin_Form {
    
    public function init() {
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
        
        $email = $this->createElement('text', 'email');
        $email->setLabel('Email');
        $email->setDecorators(self::$textAdminDecorators);
        $email->setAttrib('class', 'form-control');
        
        $name = $this->createElement('text', 'name');
        $name->setLabel('Company name');
        $name->setRequired();
        $name->setDecorators(self::$textAdminDecorators);
        $name->setAttrib('class', 'form-control');
        
        $office_name = $this->createElement('text', 'office_name');
        $office_name->setLabel('Office name');
        $office_name->setDecorators(self::$textAdminDecorators);
        $office_name->setAttrib('class', 'form-control');
        
        
        $description = $this->createElement('textarea', 'description');
        $description->setLabel('Description');
        $description->setDecorators(self::$textAdminDecorators)
                ->setAttrib('rows',10)
                ;
        $description->setAttrib('class', 'form-control');
        
        $address = $this->createElement('text', 'address');
        $address->setLabel('Address');
        $address->setRequired();
        $address->setDecorators(self::$textAdminDecorators);
        $address->setAttrib('class', 'form-control');
        
        
        $town = $this->createElement('text', 'town');
        $town->setLabel('Town');
        $town->setRequired();
        $town->setDecorators(self::$textAdminDecorators);
        $town->setAttrib('class', 'form-control');
        
        $county = $this->createElement('text', 'county');
        $county->setLabel('County');
        $county->setDecorators(self::$textAdminDecorators);
        $county->setAttrib('class', 'form-control');
        
        $postcode = $this->createElement('text', 'postcode');
        $postcode->setLabel('Postcode');
        $postcode->setDecorators(self::$textAdminDecorators);
        $postcode->setAttrib('class', 'form-control');
        
        $phone = $this->createElement('text', 'phone');
        $phone->setLabel('Phone');
        $phone->setDecorators(self::$textAdminDecorators);
        $phone->setAttrib('class', 'form-control');
       
        $facebook = $this->createElement('text', 'facebook');
        $facebook->setLabel('Facebook');
        $facebook->setDecorators(self::$textAdminDecorators);
        $facebook->setAttrib('class', 'form-control');
        
        $twitter = $this->createElement('text', 'twitter');
        $twitter->setLabel('Twitter');
        $twitter->setDecorators(self::$textAdminDecorators);
        $twitter->setAttrib('class', 'form-control');
        
        $branch_email = $this->createElement('text', 'branch_email');
        $branch_email->setLabel('Email');
        $branch_email->setDecorators(self::$textAdminDecorators);
        $branch_email->setAttrib('class', 'form-control');
        
        $agent_email = $this->createElement('text', 'agent_email');
        $agent_email->setLabel('Email');
        $agent_email->setDecorators(self::$textAdminDecorators);
        $agent_email->setAttrib('class', 'form-control');
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(self::$submitDecorators);
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));

        $this->setElements(array(
            $id,
            $firstname,
            $lastname,
            $email,
            $name,
            $branch_email,
            $agent_email,
            $description,
            $address,
            $office_name,
            $town,
            $county,
            $postcode,
            $phone,
            $url,
            $facebook,
            $twitter,
            $submit
        ));
    }
}

