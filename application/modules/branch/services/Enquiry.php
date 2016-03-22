<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_Service_Enquiry extends MF_Service_ServiceAbstract {
    
    protected $contactTable;
    
    public function init() {
        $this->contactTable = Doctrine_Core::getTable('Branch_Model_Doctrine_Enquiry');
    }
      
    public function getBranch($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->contactTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllBranchs(){
       return $this->contactTable->findAll();
   }
    
    public function saveEnquiryFromArray($values) {
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

