<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Job_Service_Application extends MF_Service_ServiceAbstract {
    
    protected $applicationTable;
    
    public function init() {
        $this->applicationTable = Doctrine_Core::getTable('Job_Model_Doctrine_Application');
    }
      
    public function getJob($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->applicationTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllJobs(){
       return $this->applicationTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->applicationTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveApplicationFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$application = $this->applicationTable->getProxy($values['id'])) {
            $application = $this->applicationTable->getRecord();
        }
        
        $application->fromArray($values);
//        Zend_Debug::dump($application->toArray());exit;
        $application->save();
        
        return $application;
    }
    
}

