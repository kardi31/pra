<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Default_Service_Postcode extends MF_Service_ServiceAbstract {
    
    protected $postcodeCountTable;
    
    public function init() {
        $this->postcodeTable = Doctrine_Core::getTable('Default_Model_Doctrine_Postcode');
        $this->postcodeCountTable = Doctrine_Core::getTable('Default_Model_Doctrine_PostcodeCount');
    }
      
    public function getDefault($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->postcodeTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllDefaults(){
       return $this->postcodeTable->findAll();
   }
    
    public function savePostcodeFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->postcodeTable->getProxy($values['id'])) {
            $record = $this->postcodeTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
    public function savePostcodeCountFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->postcodeCountTable->getProxy($values['id'])) {
            $record = $this->postcodeCountTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
}

