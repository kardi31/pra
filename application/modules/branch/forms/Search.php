<?php

/**
 * News_Form_News
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_Form_Search extends Admin_Form {
    
    public function init() {
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
      

        $rating = $this->createElement('multiCheckbox', 'rating');
        $rating->setLabel('Publish');
        $rating->setDecorators(self::$checkgroupDecorators);
        $rating->setAttrib('class', 'span8');
        for($i=1;$i<=5;$i++){
            $rating->addMultiOption($i,$i);
        }
      
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));

        $this->setElements(array(
            $id,
            $rating,
            $submit
        ));
    }
}

