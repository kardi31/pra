<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_Service_Ranking extends MF_Service_ServiceAbstract {
    
    protected $rankingMonthlyTable;
    protected $rankingWeeklyTable;
    
    public function init() {
        $this->rankingMonthlyTable = Doctrine_Core::getTable('Agent_Model_Doctrine_HistoricRanking');
        $this->rankingWeeklyTable = Doctrine_Core::getTable('Agent_Model_Doctrine_HistoricRankingWeekly');
    }
      
    public function getAgent($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->rankingMonthlyTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllAgents(){
       return $this->rankingMonthlyTable->findAll();
   }
    
    public function saveMonthlyRankingFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$agent = $this->rankingMonthlyTable->getProxy($values['id'])) {
            $agent = $this->rankingMonthlyTable->getRecord();
        }
        $agent->fromArray($values);
//        Zend_Debug::dump($agent->toArray());exit;
        $agent->save();
        
        return $agent;
    }
    
    public function saveWeeklyRankingFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$agent = $this->rankingWeeklyTable->getProxy($values['id'])) {
            $agent = $this->rankingWeeklyTable->getRecord();
        }
        $agent->fromArray($values);
        $agent->save();
        
        return $agent;
    }
    
    public function getBestAgentOfLastMonth($hydrationMode = Doctrine_Core::HYDRATE_ARRAY){
        $q = $this->rankingMonthlyTable->createQuery('r');
        $q->orderBy('year DESC, month DESC, position ASC');
        $q->leftJoin('r.Agent a');
        $q->select('r.*,a.*');
        return $q->fetchOne(array(),$hydrationMode);
    }
    
    
    public function getAgentMonthlyRankings($agent_id,$limit = 10,$hydrationMode = Doctrine_Core::HYDRATE_ARRAY){
        $q = $this->rankingMonthlyTable->createQuery('r');
        $q->orderBy('year ASC, month ASC');
        $q->leftJoin('r.Agent a');
        $q->addWhere('r.agent_id = ?',$agent_id);
        $q->limit($limit);
        $q->select('r.*,a.*');
        return $q->execute(array(),$hydrationMode);
    }
}

