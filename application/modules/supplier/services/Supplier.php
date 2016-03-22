<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Supplier_Service_Supplier extends MF_Service_ServiceAbstract {
    
    protected $supplierTable;
    
    public function init() {
        $this->supplierTable = Doctrine_Core::getTable('Supplier_Model_Doctrine_Supplier');
    }
      
    public function getSupplier($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->supplierTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllSuppliers(){
       return $this->supplierTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->supplierTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveSupplierFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->supplierTable->getProxy($values['id'])) {
            $record = $this->supplierTable->getRecord();
        }
        
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
}

