<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_Service_Contact extends MF_Service_ServiceAbstract {
    
    protected $contactTable;
    
    public function init() {
        $this->contactTable = Doctrine_Core::getTable('Agent_Model_Doctrine_Contact');
    }
      
    public function getAgent($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->contactTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllAgents(){
       return $this->contactTable->findAll();
   }
    
    public function saveContactFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$agent = $this->contactTable->getProxy($values['id'])) {
            $agent = $this->contactTable->getRecord();
        }
        $agent->fromArray($values);
        $agent->save();
        
        return $agent;
    }
    
}

