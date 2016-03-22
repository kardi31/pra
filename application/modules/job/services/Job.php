<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Job_Service_Job extends MF_Service_ServiceAbstract {
    
    protected $jobTable;
    
    public function init() {
        $this->jobTable = Doctrine_Core::getTable('Job_Model_Doctrine_Job');
    }
      
    public function getJob($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->jobTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllJobs(){
       return $this->jobTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->jobTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveJobFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$job = $this->jobTable->getProxy($values['id'])) {
            $job = $this->jobTable->getRecord();
        }
        
        $job->fromArray($values);
//        Zend_Debug::dump($job->toArray());exit;
        $job->save();
        
        return $job;
    }
    
}

