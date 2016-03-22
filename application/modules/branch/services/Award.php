<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_Service_Award extends MF_Service_ServiceAbstract {
    
    protected $awardTable;
    
    public function init() {
        $this->awardTable = Doctrine_Core::getTable('Branch_Model_Doctrine_Awards');
    }
      
    public function getBranch($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->awardTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllBranchs(){
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

