<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Supplier_Service_Review extends MF_Service_ServiceAbstract {
    
    protected $reviewTable;
    
    public function init() {
        $this->reviewTable = Doctrine_Core::getTable('Supplier_Model_Doctrine_Review');
    }
      
    public function getReview($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->reviewTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllReviews(){
       return $this->reviewTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->reviewTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveReviewFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->reviewTable->getProxy($values['id'])) {
            $record = $this->reviewTable->getRecord();
        }
        
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
}

