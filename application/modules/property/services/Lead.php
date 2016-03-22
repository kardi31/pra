<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Property_Service_Lead extends MF_Service_ServiceAbstract {
    
    protected $leadTable;
    
    public function init() {
        $this->leadTable = Doctrine_Core::getTable('Property_Model_Doctrine_Lead');
    }
      
    public function getProperty($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->leadTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllPropertys(){
       return $this->leadTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->leadTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveLeadFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->leadTable->getProxy($values['id'])) {
            $record = $this->leadTable->getRecord();
        }
        
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
}

