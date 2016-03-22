<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Default_Service_Redirect extends MF_Service_ServiceAbstract {
    
    protected $redirectTable;
    protected $redirectStaffTable;
    
    public function init() {
        $this->redirectTable = Doctrine_Core::getTable('Default_Model_Doctrine_Redirect');
        $this->redirectStaffTable = Doctrine_Core::getTable('Default_Model_Doctrine_StaffRedirect');
    }
      
    public function getDefault($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->redirectTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllDefaults(){
       return $this->redirectTable->findAll();
   }
    
    public function saveRedirectFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->redirectTable->getProxy($values['id'])) {
            $record = $this->redirectTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
    public function saveRedirectStaffFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->redirectStaffTable->getProxy($values['id'])) {
            $record = $this->redirectStaffTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
}

