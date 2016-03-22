<?php

/**
 * Lockout
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Default_Service_Lockout extends MF_Service_ServiceAbstract {
    
    protected $bannedTable;
    
    public function init() {
        $this->lockoutTable = Doctrine_Core::getTable('Default_Model_Doctrine_Lockout');
    }
    
    public function setLockout($id, $value) {
        if(!$lockout = $this->getLockout($id)) {
            $lockout = $this->lockoutTable->getRecord();
            $lockout->setId($id);
        }
        $lockout->setValue($value);
        $lockout->save();
    }
    
    public function getLockout($id, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->lockoutTable->findOneById($id, $hydrationMode);
    }
    
    public function getAllLockout($hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->lockoutTable->findAll($hydrationMode);
    }
    

    public function saveLockoutFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->lockoutTable->getProxy($values['id'])) {
            $record = $this->lockoutTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
}

