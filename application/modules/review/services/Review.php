<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Review_Service_Review extends MF_Service_ServiceAbstract {
    
    protected $reviewTable;
    protected $filesTable;
    protected $tempTable;
    
    public function init() {
        $this->reviewTable = Doctrine_Core::getTable('Review_Model_Doctrine_Review');
        $this->tempTable = Doctrine_Core::getTable('Review_Model_Doctrine_Temp');
        $this->filesTable = Doctrine_Core::getTable('Review_Model_Doctrine_Files');
    }
      
    public function getReview($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->reviewTable->findOneBy($field, $id, $hydrationMode);
    }
    public function getTempReview($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->tempTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllReviews(){
       return $this->reviewTable->findAll();
   }
   public function getNotApprovedReviews($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->tempTable->createQuery('r');
       return $q->count(array(),$hydrationMode);
   }
   
   public function calculateBranchesVotesAndRating($branchId = false){
        $q = $this->reviewTable->createQuery('r');
        $q->innerJoin('r.Branch b');
        $q->groupBy('branch_id');
        $q->select('count(id) as sum_votes');
        $q->addSelect('ROUND(AVG(r.rating)) as avg_rating');
        $q->addSelect('ROUND(AVG(r.recommend),2) as avg_reco');
        $q->addSelect('r.*,b.*');
        if($branchId){
            $q->addWhere('r.branch_id = '.$branchId);
        }
        
        $result = $q->execute();
        
        foreach($result as $reviewBranches){
            $branch = $reviewBranches->get('Branch');
            $branch->set('votes',(int)$reviewBranches['sum_votes']);
            $branch->set('rating',$reviewBranches['avg_rating']);
            $branch->set('customer_satisfaction',$reviewBranches['avg_reco']);
            
            $points = round((int)$reviewBranches['sum_votes']*$reviewBranches['avg_rating'],2);
            
            $branch->set('points',$points);
            $branch->save();
        }
   }
   
   public function calculateAgentsVotesAndRating($agentId = false){
        $q = $this->reviewTable->createQuery('r');
        $q->innerJoin('r.Agent a');
        $q->groupBy('agent_id');
        $q->select('count(id) as sum_votes');
        $q->addSelect('ROUND(AVG(r.rating)) as avg_rating');
        $q->addSelect('ROUND(AVG(r.recommend),2) as avg_reco');
        $q->addSelect('r.*,b.*');
        if($agentId){
            $q->addWhere('r.agent_id = '.$agentId);
        }
        
        
        $result = $q->execute();
        
        
        foreach($result as $reviewAgents){
            $agent = $reviewAgents->get('Agent');
            $agent->set('votes',(int)$reviewAgents['sum_votes']);
            $agent->set('rating',$reviewAgents['avg_rating']);
            $agent->set('customer_satisfaction',$reviewAgents['avg_reco']);
            
            $points = round((int)$reviewAgents['sum_votes']*$reviewAgents['avg_rating'],2);
            
            $agent->set('points',$points);
            $agent->save();
        }
   }
   
   
   public function calculateAgentMonthlyRanking($month,$year,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        if(strlen($month)==1){
            $month = "0".$month;
        }
        $date = new DateTime();
        $date->setDate($year,$month,1);
        $month_start_date = $date->format('Y-m-d');
        $date->modify('+1 month');
        $month_finish_date = $date->format('Y-m-d');
        $q = $this->reviewTable->createQuery('r');
        $q->addWhere('DATE(r.created_at) >= ?',$month_start_date);
        $q->addWhere('DATE(r.created_at) < ?',$month_finish_date);
        $q->groupBy('r.agent_id');
        $q->select('sum(rating) as review_counter,agent_id');
        $q->orderBy('review_counter DESC');
        return $q->execute(array(),$hydrationMode);
   }
   
   public function calculateAgentWeeklyRanking($month,$year,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        if(strlen($month)==1){
            $weekNo = "0".$month;
        }
        $date = new DateTime();
        $date->setISODate($year,$weekNo);
        $week_start_date = $date->format('Y-m-d');
        $date->modify('+7 day');
        $week_finish_date = $date->format('Y-m-d');
        $q = $this->reviewTable->createQuery('r');
        $q->addWhere('DATE(r.created_at) >= ?',$week_start_date);
        $q->addWhere('DATE(r.created_at) < ?',$week_finish_date);
        $q->groupBy('r.agent_id');
        $q->select('sum(rating) as review_counter,agent_id');
        $q->orderBy('review_counter DESC');
        return $q->execute(array(),$hydrationMode);
   }
   
   public function activate($reviewTemp){
       $values = array();
       
        $values['activation_ip'] = $_SERVER['REMOTE_ADDR'];
        $values['activation_hostname'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $values['activated'] = 1;
        
        $reviewTemp->fromArray($values);
        $reviewTemp->save();
        
        return $reviewTemp;
        
   }
   
   public function saveNewTempReview($values){
        $values['ip'] = $_SERVER['REMOTE_ADDR'];
        $values['hostname'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        
        $values['service_date'] = MF_Text::timeFormat($values['service_date'],'Y-m-d H:i:s','d/m/Y');

        $values['staff'] = (int)$values['staff'];
        $values['staff2'] = (int)$values['staff2'];
        $row = $this->tempTable->getRecord();
        $row->fromArray($values);
        $row->save();
        
        return $row;
   }
   
   public function getBranchReviewPaginationQuery($branch_id){
       $q = $this->reviewTable->createQuery('r');
       $q->addWhere('r.branch_id = ?',$branch_id);
       $q->leftJoin('r.Staff s');
       $q->leftJoin('r.Staff2 s2');
       $q->leftJoin('r.Translation rt');
       $q->leftJoin('r.Branch b');
       $q->leftJoin('r.Comments c');
       $q->orderBy('r.featured DESC, r.created_at DESC,r.id DESC');
       $q->addSelect('r.*,s.*,s2.*,b.*,c.*,rt.*');
       return $q;
   }
   
   public function getAgentReviewPaginationQuery($agent_id){
       $q = $this->reviewTable->createQuery('r');
       $q->addWhere('r.agent_id = ?',$agent_id);
       $q->leftJoin('r.Staff s');
       $q->leftJoin('r.Staff2 s2');
       $q->leftJoin('r.Translation rt');
       $q->leftJoin('r.Branch b');
       $q->leftJoin('r.Comments c');
       $q->addWhere('r.view = 1');
       $q->orderBy('r.featured DESC, r.created_at DESC,r.id DESC');
       $q->addSelect('r.*,s.*,s2.*,b.*,c.*,rt.*');
       return $q;
   }
   
   
   public function getStaffReviewPaginationQuery($staff_id){
       $q = $this->reviewTable->createQuery('r');
       $q->addWhere('r.staff = ?',$staff_id);
       $q->orWhere('r.staff2 = ?',$staff_id);
       $q->leftJoin('r.Staff s');
       $q->leftJoin('r.Staff2 s2');
       $q->leftJoin('r.Translation rt');
       $q->leftJoin('r.Branch b');
       $q->leftJoin('r.Comments c');
       $q->orderBy('r.featured DESC, r.created_at DESC,r.id DESC');
       $q->addSelect('r.*,s.*,s2.*,b.*,c.*,rt.*');
       return $q;
   }
   
    public function saveReviewFromTemp($values) {
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        $record = $this->reviewTable->getRecord();
        $record->fromArray($values);
        
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            if(is_array($values['translations'][$language])) {
                $record->Translation[$language]->review = $values['translations'][$language]['review'];
                $record->Translation[$language]->feedback = $values['translations'][$language]['feedback'];
            }
        }
        
        $record->save();
        
        return $record;
    }
    
    public function saveReviewFromArray($values) {
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->reviewTable->getProxy($values['id'])) {
            $record = $this->reviewTable->getRecord();
        }
        $record->fromArray($values);
        
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            if(is_array($values['translations'][$language])) {
                $record->Translation[$language]->review = $values['translations'][$language]['review'];
                $record->Translation[$language]->feedback = $values['translations'][$language]['feedback'];
            }
        }
        
        $record->save();
        
        return $record;
    }
    
    public function getReviewAdminForm(Review_Model_Doctrine_Review $review = null,  Agent_Model_Doctrine_Agent $agent = null) {
        $form = new Review_Form_ReviewAdmin();
        
        foreach($agent['Branches'] as $branch){
            $form->getElement('branch_id')->addMultiOption($branch['id'],$branch['office_name']." ".$branch['town']." ".$branch['postcode']);
        }
        
        foreach($agent['StaffMembers'] as $staff){
            $form->getElement('staff1')->addMultiOption($staff['id'],$staff['firstname']." ".$staff['lastname']);
            $form->getElement('staff2')->addMultiOption($staff['id'],$staff['firstname']." ".$staff['lastname']);
        }
        
        if(null != $review) {
            $bannerArray = $review->toArray();
            $form->populate($bannerArray);
//            
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            $languages = $i18nService->getLanguageList();
            foreach($languages as $language) {
                $i18nSubform = $form->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('review')->setValue($review['Translation'][$language]['review']);
                    $i18nSubform->getElement('feedback')->setValue($review['Translation'][$language]['feedback']);
                }
            }
        }
        return $form;
    }
    
    
}

