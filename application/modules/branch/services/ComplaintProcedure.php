<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_Service_ComplaintProcedure extends MF_Service_ServiceAbstract {
    
    protected $complaintTable;
    
    public function init() {
        $this->complaintTable = Doctrine_Core::getTable('Branch_Model_Doctrine_ComplaintProcedure');
    }
      
    public function getBranch($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->complaintTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllBranchs(){
       return $this->complaintTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->complaintTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveComplaintProcedureFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$complaint = $this->complaintTable->getProxy($values['id'])) {
            $complaint = $this->complaintTable->getRecord();
        }
        
        $complaint->fromArray($values);
//        Zend_Debug::dump($complaint->toArray());exit;
        $complaint->save();
        
        return $complaint;
    }
    
}

