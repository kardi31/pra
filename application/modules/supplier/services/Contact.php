<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Supplier_Service_Contact extends MF_Service_ServiceAbstract {
    
    protected $contactTable;
    
    public function init() {
        $this->contactTable = Doctrine_Core::getTable('Supplier_Model_Doctrine_Contact');
    }
      
    public function getContact($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->contactTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllContacts(){
       return $this->contactTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->contactTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveContactFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->contactTable->getProxy($values['id'])) {
            $record = $this->contactTable->getRecord();
        }
        
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
}

