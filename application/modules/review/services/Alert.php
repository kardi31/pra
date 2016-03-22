<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Review_Service_Alert extends MF_Service_ServiceAbstract {
    
    protected $alertTable;
    protected $alertSendTable;
    
    public function init() {
        $this->alertTable = Doctrine_Core::getTable('Review_Model_Doctrine_Alert');
        $this->alertSendTable = Doctrine_Core::getTable('Review_Model_Doctrine_AlertSend');
    }
      
    public function getReview($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->alertTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllReviews(){
       return $this->alertTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->alertTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveAlertFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->alertTable->getProxy($values['id'])) {
            $record = $this->alertSendTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
    public function saveAlertToSendFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->alertSendTable->getProxy($values['id'])) {
            $record = $this->alertSendTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
}

