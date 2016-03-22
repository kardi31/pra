<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Property_Service_Let extends MF_Service_ServiceAbstract {
    
    protected $letTable;
    
    public function init() {
        $this->letTable = Doctrine_Core::getTable('Property_Model_Doctrine_Let');
    }
      
    public function getProperty($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->letTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllPropertys(){
       return $this->letTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->letTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveLetFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->letTable->getProxy($values['id'])) {
            $record = $this->letTable->getRecord();
        }
        
        $record->fromArray($values);
        $record->save();
        
        return $record;
    }
    
}

