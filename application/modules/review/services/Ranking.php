<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Review_Service_Ranking extends MF_Service_ServiceAbstract {
    
    protected $rankingTable;
    
    public function init() {
        $this->rankingTable = Doctrine_Core::getTable('Review_Model_Doctrine_RankingWeek');
    }
      
    public function getReview($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->rankingTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllReviews(){
       return $this->rankingTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->rankingTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveRankingWeekFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->rankingTable->getProxy($values['id'])) {
            $record = $this->rankingTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
}

