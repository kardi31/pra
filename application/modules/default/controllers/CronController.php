<?php

class Default_CronController extends MF_Controller_Action
{
    
   public function calculateVotesAndRatingAction(){
        $this->_helper->actionStack('layout');
       
        $reviewService = $this->_service->getService('Review_Service_Review');

        $reviewService->calculateBranchesVotesAndRating();
        $reviewService->calculateAgentsVotesAndRating();
        
        echo 'Cronbjob done';exit;
        
   }
   
   public function rankAgentsAction(){
       set_time_limit(0);
       
        $this->_helper->actionStack('layout');
       
        $agentService = $this->_service->getService('Agent_Service_Agent');

        $agentService->calculateAgentsRank();
        
        echo 'Cronbjob done';exit;
   }
   
   public function rankBranchesAction(){
       set_time_limit(0);
       
        $this->_helper->actionStack('layout');
       
        $branchService = $this->_service->getService('Branch_Service_Branch');

        $branchService->calculateBranchesRank();
        
        echo 'Cronbjob done';exit;
   }
   
}
