<?php

/**
 * Advertisment_Form_Category
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class Advertisment_Form_Category extends Admin_Form {
    
    public function init() {
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
  
         $title = $this->createElement('text', 'title');
        $title->setLabel('Title');
        $title->setDecorators(self::$textDecorators);
        $title->setAttrib('class', 'span8');

         $group_id = $this->createElement('select', 'group_id');
        $group_id->setLabel('Grupa');
        $group_id->setDecorators(self::$selectDecorators);
        $group_id->setAttrib('class', 'span8');
        $group_id->setRequired(false);
        
        
        $content = $this->createElement('textarea', 'content');
        $content->setLabel('Content');
        $content->setDecorators(self::$tinymceDecorators);
        $content->setAttrib('class', 'span8 tinymce');


        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttrib('type', 'submit');
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));

        $this->setElements(array(
            $id,
            $title,
            $group_id,
            $content,
            $submit
        ));
    }
}

