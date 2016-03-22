<?php

/**
 * CompareFees
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Default_Service_CompareFees extends MF_Service_ServiceAbstract {
    
    protected $compareFeesTable;
    
    public function init() {
        $this->compareFeesTable = Doctrine_Core::getTable('Default_Model_Doctrine_CompareFees');
    }
    
    public function setCompareFees($id, $value) {
        if(!$compareFees = $this->getCompareFees($id)) {
            $compareFees = $this->compareFeesTable->getRecord();
            $compareFees->setId($id);
        }
        $compareFees->setValue($value);
        $compareFees->save();
    }
    
    public function getCompareFees($id, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->compareFeesTable->findOneById($id, $hydrationMode);
    }
    
    public function getAllCompareFees($hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->compareFeesTable->findAll($hydrationMode);
    }
    

    public function saveFeesFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->compareFeesTable->getProxy($values['id'])) {
            $record = $this->compareFeesTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
}

