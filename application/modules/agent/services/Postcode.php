<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_Service_Postcode extends MF_Service_ServiceAbstract {
    
    protected $postcodeTable;
    
    public function init() {
        $this->postcodeTable = Doctrine_Core::getTable('Agent_Model_Doctrine_Postcode');
    }
      
    public function getAgent($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->postcodeTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllAgents(){
       return $this->postcodeTable->findAll();
   }
    
    public function savePostcodeFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$agent = $this->postcodeTable->getProxy($values['id'])) {
            $agent = $this->postcodeTable->getRecord();
        }
        $agent->fromArray($values);
        $agent->save();
        
        return $agent;
    }
    
}

