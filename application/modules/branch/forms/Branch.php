<?php

/**
 * News_Form_News
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_Form_Branch extends Admin_Form {
    
    public function init() {
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        $agent_id = $this->createElement('hidden', 'agent_id');
        $agent_id->setDecorators(array('ViewHelper'));
        
        $office_name = $this->createElement('text', 'office_name');
        $office_name->setLabel('Office name');
        $office_name->setDecorators(self::$textAdminDecorators);
        $office_name->setRequired();
        $office_name->setAttrib('class', 'form-control');
        
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
        $county->setRequired();
        $county->setDecorators(self::$textAdminDecorators);
        $county->setAttrib('class', 'form-control');
        
        $postcode = $this->createElement('text', 'postcode');
        $postcode->setLabel('Postcode');
        $postcode->setRequired();
        $postcode->setDecorators(self::$textAdminDecorators);
        $postcode->setAttrib('class', 'form-control');
        
        $phone = $this->createElement('text', 'phone');
        $phone->setLabel('Phone');
        $phone->setDecorators(self::$textAdminDecorators);
        $phone->setAttrib('class', 'form-control');
       
        $url = $this->createElement('text', 'url');
        $url->setLabel('Website');
        $url->setDecorators(self::$textAdminDecorators);
        $url->setAttrib('class', 'form-control');
        
        $email = $this->createElement('text', 'email');
        $email->setLabel('Email');
        $email->setRequired();
        $email->setDecorators(self::$textAdminDecorators);
        $email->setAttrib('class', 'form-control');
        
        $facebook = $this->createElement('text', 'facebook');
        $facebook->setLabel('Facebook');
        $facebook->setDecorators(self::$textAdminDecorators);
        $facebook->setAttrib('class', 'form-control');
        
        $twitter = $this->createElement('text', 'twitter');
        $twitter->setLabel('Twitter');
        $twitter->setDecorators(self::$textAdminDecorators);
        $twitter->setAttrib('class', 'form-control');
        
        $description = $this->createElement('textarea', 'description');
        $description->setLabel('Description');
        $description->setDecorators(self::$textAdminDecorators);
        $description->setAttrib('class', 'form-control');
        $description->setAttrib('rows', 5);
        
        $lat = $this->createElement('text', 'lat');
        $lat->setLabel('Lat');
        $lat->setDecorators(self::$textAdminDecorators);
        $lat->setAttrib('class', 'form-control');
        
        $lng = $this->createElement('text', 'lng');
        $lng->setLabel('Lng');
        $lng->setDecorators(self::$textAdminDecorators);
        $lng->setAttrib('class', 'form-control');
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(self::$submitDecorators);
//        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));

        $this->setElements(array(
            $id,
            $address,
            $office_name,
            $email,
            $town,
            $county,
            $postcode,
            $description,
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

