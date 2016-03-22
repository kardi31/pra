<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_Service_Enquiry extends MF_Service_ServiceAbstract {
    
    protected $enquiryTable;
    
    public function init() {
        $this->enquiryTable = Doctrine_Core::getTable('Agent_Model_Doctrine_TransparentEnquiry');
    }
      
    public function getAgent($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->enquiryTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllAgents(){
       return $this->enquiryTable->findAll();
   }
    
    public function saveEnquiryFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->enquiryTable->getProxy($values['id'])) {
            $record = $this->enquiryTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
}

