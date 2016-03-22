<?php

/**
 * Banner_Form_Banner
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_Form_SelectAgent extends Admin_Form {
    
    public function init() {
        $agentName = $this->createElement('select', 'agent_name');
        $agentName->setLabel('Company name');
        $agentName->setRequired(false);
        $agentName->setDecorators(self::$selectDecorators);
        $agentName->setAttrib('class','form-control');
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Save');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));

        $this->setElements(array(
            $agentName,
            $submit
        ));
    }
}

