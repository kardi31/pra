<?php

/**
 * Banned
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Default_Service_Banned extends MF_Service_ServiceAbstract {
    
    protected $bannedTable;
    
    public function init() {
        $this->bannedTable = Doctrine_Core::getTable('Default_Model_Doctrine_Banned');
    }
    
    public function setBanned($id, $value) {
        if(!$banned = $this->getBanned($id)) {
            $banned = $this->bannedTable->getRecord();
            $banned->setId($id);
        }
        $banned->setValue($value);
        $banned->save();
    }
    
    public function getBanned($id, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->bannedTable->findOneById($id, $hydrationMode);
    }
    
    public function getAllBanned($hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->bannedTable->findAll($hydrationMode);
    }
    

    public function saveBannedFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->bannedTable->getProxy($values['id'])) {
            $record = $this->bannedTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
}

