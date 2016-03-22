<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_Service_Member extends MF_Service_ServiceAbstract {
    
    protected $memberTable;
    
    public function init() {
        $this->memberTable = Doctrine_Core::getTable('Branch_Model_Doctrine_Member');
    }
      
    public function getAgent($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->memberTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllAgents(){
       return $this->memberTable->findAll();
   }
    
    public function saveMemberFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$agent = $this->memberTable->getProxy($values['id'])) {
            $agent = $this->memberTable->getRecord();
        }
        $agent->fromArray($values);
        $agent->save();
        
        return $agent;
    }
    
    public function getFieldNames(){
        return $this->memberTable->getFieldNames();
    }
    
}

