<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_Service_Rightmove extends MF_Service_ServiceAbstract {
    
    protected $rightmoveTable;
    
    public function init() {
        $this->rightmoveTable = Doctrine_Core::getTable('Branch_Model_Doctrine_Rightmove');
    }
      
    public function getBranch($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->rightmoveTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllBranchs(){
       return $this->rightmoveTable->findAll();
   }
    
    public function saveRightmoveFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->rightmoveTable->getProxy($values['id'])) {
            $record = $this->rightmoveTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
}

