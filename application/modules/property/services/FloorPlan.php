<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Property_Service_FloorPlan extends MF_Service_ServiceAbstract {
    
    protected $floorPlanTable;
    
    public function init() {
        $this->floorPlanTable = Doctrine_Core::getTable('Property_Model_Doctrine_FloorPlan');
    }
      
    public function getProperty($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->floorPlanTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllPropertys(){
       return $this->floorPlanTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->floorPlanTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveFloorPlanFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->floorPlanTable->getProxy($values['id'])) {
            $record = $this->floorPlanTable->getRecord();
        }
        
        $record->fromArray($values);
        $record->save();
        
        return $record;
    }
    
}

