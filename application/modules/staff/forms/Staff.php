<?php

/**
 * News_Form_News
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Staff_Form_Staff extends Admin_Form {
    
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
        
        
        $position = $this->createElement('text', 'position');
        $position->setLabel('Position in company');
        $position->setDecorators(self::$textAdminDecorators);
        $position->setAttrib('class', 'form-control');
        
        $branchId = $this->createElement('select', 'branch_id');
        $branchId->setLabel('Branch');
        $branchId->setDecorators(self::$selectAdminDecorators);
        $branchId->setAttrib('class', 'form-control');
        
        $description = $this->createElement('textarea', 'description');
        $description->setLabel('Description');
        $description->setDecorators(self::$textAdminDecorators)
                ->setAttrib('rows',10)
                ;
        $description->setAttrib('class', 'form-control');
        
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(self::$submitDecorators);
//        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));

        $this->setElements(array(
            $id,
            $firstname,
            $lastname,
            $branchId,
            $description,
            $position,
            $submit
        ));
    }
}

