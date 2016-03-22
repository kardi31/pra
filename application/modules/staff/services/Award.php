<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Staff_Service_Award extends MF_Service_ServiceAbstract {
    
    protected $awardTable;
    
    public function init() {
        $this->awardTable = Doctrine_Core::getTable('Staff_Model_Doctrine_Award');
    }
      
    public function getStaff($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->awardTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllStaffs(){
       return $this->awardTable->findAll();
   }
    
    public function saveAwardFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->awardTable->getProxy($values['id'])) {
            $record = $this->awardTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
}

