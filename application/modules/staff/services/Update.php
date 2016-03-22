<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Staff_Service_Update extends MF_Service_ServiceAbstract {
    
    protected $updateTable;
    
    public function init() {
        $this->updateTable = Doctrine_Core::getTable('Staff_Model_Doctrine_Update');
    }
      
    public function getStaff($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->updateTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllStaffs(){
       return $this->updateTable->findAll();
   }
    
    public function saveUpdateFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$update = $this->updateTable->getProxy($values['id'])) {
            $update = $this->updateTable->getRecord();
        }
        
        $update->fromArray($values);
        $update->save();
        
        return $update;
    }
}

