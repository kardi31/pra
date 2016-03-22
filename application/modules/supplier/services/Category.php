<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Supplier_Service_Category extends MF_Service_ServiceAbstract {
    
    protected $categoryTable;
    
    public function init() {
        $this->categoryTable = Doctrine_Core::getTable('Supplier_Model_Doctrine_Category');
    }
      
    public function getCategory($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->categoryTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllCategorys(){
       return $this->categoryTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->categoryTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveCategoryFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->categoryTable->getProxy($values['id'])) {
            $record = $this->categoryTable->getRecord();
        }
        
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
}

