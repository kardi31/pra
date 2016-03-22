<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_Service_Notes extends MF_Service_ServiceAbstract {
    
    protected $notesTable;
    
    public function init() {
        $this->notesTable = Doctrine_Core::getTable('Agent_Model_Doctrine_Notes');
    }
      
    public function getAgent($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->notesTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllAgents(){
       return $this->notesTable->findAll();
   }
    
    public function saveNotesFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$agent = $this->notesTable->getProxy($values['id'])) {
            $agent = $this->notesTable->getRecord();
        }
        $agent->fromArray($values);
        $agent->save();
        
        return $agent;
    }
    
}

