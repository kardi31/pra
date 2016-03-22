<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Advertising_Service_Advertising extends MF_Service_ServiceAbstract {
    
    protected $advertisingTable;
    protected $agentTable;
    protected $branchTable;
    protected $cityTable;
    protected $pageTable;
    protected $positionTable;
    
    public function init() {
        $this->advertisingTable = Doctrine_Core::getTable('Advertising_Model_Doctrine_Advertising');
        $this->agentTable = Doctrine_Core::getTable('Advertising_Model_Doctrine_Agent');
        $this->branchTable = Doctrine_Core::getTable('Advertising_Model_Doctrine_Branch');
        $this->cityTable = Doctrine_Core::getTable('Advertising_Model_Doctrine_City');
        $this->pageTable = Doctrine_Core::getTable('Advertising_Model_Doctrine_Page');
        $this->positionTable = Doctrine_Core::getTable('Advertising_Model_Doctrine_Position');
        $this->sizeTable = Doctrine_Core::getTable('Advertising_Model_Doctrine_Size');
    }
      
    public function getAdvertising($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->advertisingTable->findOneBy($field, $id, $hydrationMode);
    }
    
    
    public function getPage($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->pageTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function getPosition($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->positionTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function getSize($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->sizeTable->findOneBy($field, $id, $hydrationMode);
    }
    
   public function getAllAdvertisings(){
       return $this->advertisingTable->findAll();
   }
   
   public function getAgentAd($agent_id,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->advertisingTable->createQuery('a');
       $q->leftJoin('a.Agent ag');
       
       $q->addWhere('ag.agent_id = ?',$agent_id);
       return $q->fetchOne(array(),$hydrationMode);
   }
   
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->advertisingTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveAdvertisingFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$advertising = $this->advertisingTable->getProxy($values['id'])) {
            $advertising = $this->advertisingTable->getRecord();
        }
        
        $advertising->fromArray($values);
//        Zend_Debug::dump($advertising->toArray());exit;
        $advertising->save();
        
        return $advertising;
    }
    
    public function saveAdvertisingAgentFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$advertising = $this->agentTable->getProxy($values['id'])) {
            $advertising = $this->agentTable->getRecord();
        }
        
        $advertising->fromArray($values);
        $advertising->save();
        
        return $advertising;
    }
    
     
    public function saveAdvertisingBranchFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$advertising = $this->branchTable->getProxy($values['id'])) {
            $advertising = $this->branchTable->getRecord();
        }
        
        $advertising->fromArray($values);
        $advertising->save();
        
        return $advertising;
    }
    
    public function saveAdvertisingCityFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$advertising = $this->cityTable->getProxy($values['id'])) {
            $advertising = $this->cityTable->getRecord();
        }
        
        $advertising->fromArray($values);
        $advertising->save();
        
        return $advertising;
    }
    
    public function saveAdvertisingPageFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$advertising = $this->getPage($values['value'],'value')) {
            $advertising = $this->pageTable->getRecord();
        }
        
        $advertising->fromArray($values);
        $advertising->save();
        
        return $advertising;
    }
    
    public function saveAdvertisingPositionFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$advertising = $this->getPosition($values['value'],'value')) {
            $advertising = $this->positionTable->getRecord();
        }
        
        $advertising->fromArray($values);
        $advertising->save();
        
        return $advertising;
    }
    
    public function saveAdvertisingSizeFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$advertising = $this->getSize($values['value'],'value')) {
            $advertising = $this->sizeTable->getRecord();
        }
        
        $advertising->fromArray($values);
        $advertising->save();
        
        return $advertising;
    }
    
}

