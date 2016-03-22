<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Staff_Service_Claim extends MF_Service_ServiceAbstract {
    
    protected $claimTable;
    
    public function init() {
        $this->claimTable = Doctrine_Core::getTable('Staff_Model_Doctrine_Claim');
    }
      
    public function getStaff($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->claimTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllStaffs(){
       return $this->claimTable->findAll();
   }
    
    public function saveClaimFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->claimTable->getProxy($values['id'])) {
            $record = $this->claimTable->getRecord();
        }
        $record->fromArray($values);
        $record->save();
        
        return $record;
    }
    
}

