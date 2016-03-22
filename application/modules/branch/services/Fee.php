<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_Service_Fee extends MF_Service_ServiceAbstract {
    
    protected $customerTable;
    
    public function init() {
        $this->feeTable = Doctrine_Core::getTable('Branch_Model_Doctrine_Fee');
    }
      
    public function getBranch($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->feeTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllBranchs(){
       return $this->feeTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->feeTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveFeesFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$complaint = $this->feeTable->getProxy($values['id'])) {
            $complaint = $this->feeTable->getRecord();
        }
//        var_dump($values);exit;
        $complaint->fromArray($values);
//        Zend_Debug::dump($complaint->toArray());exit;
        $complaint->save();
        
        return $complaint;
    }
    
}

