<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Job_Service_Unverified extends MF_Service_ServiceAbstract {
    
    protected $applicationTable;
    
    public function init() {
        $this->unverifiedTable = Doctrine_Core::getTable('Job_Model_Doctrine_Unverified');
    }
      
    public function getJob($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->unverifiedTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllJobs(){
       return $this->unverifiedTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->unverifiedTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveUnverifiedFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$unverified = $this->unverifiedTable->getProxy($values['id'])) {
            $unverified = $this->unverifiedTable->getRecord();
        }
        
        $unverified->fromArray($values);
//        Zend_Debug::dump($unverified->toArray());exit;
        $unverified->save();
        
        return $unverified;
    }
    
}

