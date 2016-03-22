<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Property_Service_Image extends MF_Service_ServiceAbstract {
    
    protected $imageTable;
    
    public function init() {
        $this->imageTable = Doctrine_Core::getTable('Property_Model_Doctrine_Image');
    }
      
    public function getProperty($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->imageTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllPropertys(){
       return $this->imageTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->imageTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveImageFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->imageTable->getProxy($values['id'])) {
            $record = $this->imageTable->getRecord();
        }
        
        $record->fromArray($values);
        $record->save();
        
        return $record;
    }
    
}

