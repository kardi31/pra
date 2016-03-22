<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_Service_Award extends MF_Service_ServiceAbstract {
    
    protected $awardTable;
    
    public function init() {
        $this->awardTable = Doctrine_Core::getTable('Agent_Model_Doctrine_Awards');
    }
      
    public function getAgent($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->awardTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllAgents(){
       return $this->awardTable->findAll();
   }
    
    public function saveAwardFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$agent = $this->awardTable->getProxy($values['id'])) {
            $agent = $this->awardTable->getRecord();
        }
        $agent->fromArray($values);
        $agent->save();
        
        return $agent;
    }
    
}

