<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Property_Service_Feature extends MF_Service_ServiceAbstract {
    
    protected $featureTable;
    
    public function init() {
        $this->featureTable = Doctrine_Core::getTable('Property_Model_Doctrine_Feature');
    }
      
    public function getProperty($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->featureTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllPropertys(){
       return $this->featureTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->featureTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveFeatureFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->featureTable->getProxy($values['id'])) {
            $record = $this->featureTable->getRecord();
        }
        
        $record->fromArray($values);
        $record->save();
        
        return $record;
    }
    
}

