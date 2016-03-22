<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_Service_Update extends MF_Service_ServiceAbstract {
    
    protected $updateTable;
    protected $updateAreaCoveredTable;
    protected $updateMemberTable;
    
    public function init() {
        $this->updateTable = Doctrine_Core::getTable('Branch_Model_Doctrine_Update');
        $this->updateAreaCoveredTable = Doctrine_Core::getTable('Branch_Model_Doctrine_UpdateAreaCovered');
        $this->updateMemberTable = Doctrine_Core::getTable('Branch_Model_Doctrine_UpdateMember');
    }
      
    public function getBranch($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->updateTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllBranchs(){
       return $this->updateTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->updateTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveUpdateFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$update = $this->updateTable->getProxy($values['id'])) {
            $update = $this->updateTable->getRecord();
        }
        
        $update->fromArray($values);
//        Zend_Debug::dump($update->toArray());exit;
        $update->save();
        
        return $update;
    }
    
    public function saveUpdateAreasCoveredFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$update = $this->updateAreaCoveredTable->getProxy($values['id'])) {
            $update = $this->updateAreaCoveredTable->getRecord();
        }
        
        $update->fromArray($values);
//        Zend_Debug::dump($update->toArray());exit;
        $update->save();
        
        return $update;
    }
    
    public function saveUpdateMemberFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$update = $this->updateMemberTable->getProxy($values['id'])) {
            $update = $this->updateMemberTable->getRecord();
        }
        
        $update->fromArray($values);
//        Zend_Debug::dump($update->toArray());exit;
        $update->save();
        
        return $update;
    }
    
}

