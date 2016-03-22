<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Staff_Service_AreaCovered extends MF_Service_ServiceAbstract {
    
    protected $areaCoveredTable;
    
    public function init() {
        $this->areaCoveredTable = Doctrine_Core::getTable('Staff_Model_Doctrine_AreaCovered');
    }
      
    public function getStaff($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->areaCoveredTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllStaffs(){
       return $this->areaCoveredTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->areaCoveredTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveAreaCoveredFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$areaCovered = $this->areaCoveredTable->getProxy($values['id'])) {
            $areaCovered = $this->areaCoveredTable->getRecord();
        }
        
        $areaCovered->fromArray($values);
        $areaCovered->save();
        
        return $areaCovered;
    }
    
}

