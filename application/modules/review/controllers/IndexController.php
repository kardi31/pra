<?php

/**
 * Banner_IndexController
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Review_IndexController extends MF_Controller_Action {
 
    public function detailsAction(){
        
        $this->_helper->layout->setLayout('page');
        
       
        
        $valuationAccuracy = $reviewService->getAgentValuationAccuracy($agent['id'],Doctrine_Core::HYDRATE_ARRAY);
        $propertyPriceRange = $propertyService->getAgentPropertyPriceRange($agent['id'],Doctrine_Core::HYDRATE_ARRAY);
        
        if($agent['premium_support']){
            $advertisingService = $this->_service->getService('Advertising_Service_Advertising');
            $ad = $advertisingService->getAgentAd($agent['id']);
            $this->view->assign('ad',$ad);
        }
        
        $query = $reviewService->getAgentReviewPaginationQuery($agent['id']);

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(30);
        
        $this->view->assign('paginator', $paginator);
        
        $this->view->assign('propertyPriceRange',$propertyPriceRange);
        $this->view->assign('valuationAccuracy',$valuationAccuracy);
        $this->view->assign('agent',$agent);
    }
    
    public function indexAction(){
        $this->_helper->layout->setLayout('page');
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $reviewService = $this->_service->getService('Review_Service_Review');
        $commentService = $this->_service->getService('Review_Service_Comment');
        $mailService = $this->_service->getService('User_Service_Mail');
         
        if(!$review = $reviewService->getReview($this->getRequest()->getParam('id'),'id')) {
            throw new Zend_Controller_Action_Exception('Review not found');
        }
        
        $comments = $commentService->getReviewComments($review['id']);
        
        
        $branch = $review['Branch'];
        $agent = $review['Agent'];
        
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Opinie o firmie '.$agent['name']
            ),
            'en' => array(
                'title' => "Customer review of ".$agent['name']
            )
        ),$this->view);
        
        if($agent['premium_support']){
            $advertisingService = $this->_service->getService('Advertising_Service_Advertising');
            $ad = $advertisingService->getAgentAd($agent['id']);
            $this->view->assign('ad',$ad);
        }
        $query = $reviewService->getBranchReviewPaginationQuery($branch['id']);

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(30);
        
        $form = new Review_Form_Comment();
        if($this->getRequest()->isPost()) {
            if($form->isValid($_POST)) {
                
                $values = $form->getValues();
                $values['review_id'] = $review['id'];
                
                $values['activation_code'] = MF_Text::createUniqueToken();
                $comment = $commentService->saveNewCommentFromArray($values);
                
                
                
                $options = $this->getFrontController()->getParam('bootstrap')->getOptions();
        
                $mail = new Zend_Mail('UTF-8');
                $mail->setSubject($this->view->translate('Activate your comment'));
                $mail->addTo($values['email'], $values['firstname'] . ' ' . $values['lastname']);
                $mail->setReplyTo($options['reply_email'], 'Pracownik');
               
                $mailService->sendCommentActivationEmail($comment,$mail, $this->view);
                
                
                $this->_helper->redirector->gotoRoute(array('type' => 'review'), 'domain-thank-you');
                
            }
        }
        
        
        $this->view->assign('paginator', $paginator);
        $this->view->assign('agent',$agent);
        $this->view->assign('branch',$branch);
        $this->view->assign('comments',$comments);
        $this->view->assign('review',$review);
        $this->view->assign('form',$form);
    }
    
    public function reviewsAction(){
        
    }
    
    public function addAction(){
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $reviewService = $this->_service->getService('Review_Service_Review');
        $staffService = $this->_service->getService('Staff_Service_Staff');
        $mailService = $this->_service->getService('User_Service_Mail');
        
        if(!$agent = $agentService->getAgent($this->getRequest()->getParam('agent'),'link')) {
            throw new Zend_Controller_Action_Exception('Agent not found');
        }
        
        
        
       $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Dodaj opinie - '.$agent['name'],
                'description' => 'Korzystałeś z usług firmy '.$agent['name'].'? Oceń firmę '.$agent['name']
            ),
            'en' => array(
                'title' => 'Add review for '.$agent['name'],
                'description' => 'Did you use '.$agent['name'].'? Rate review for '.$agent['name']
            )
        ),$this->view);
            
            
            
        $form = new Review_Form_Review();
        
        $form->getElement('branch')->addMultiOptions($branchService->prependBranchesValues($agent['id'],true));
        
        if($this->getRequest()->getParam('branch')){
            if($branch = $branchService->getAgentBranch($agent['id'],'id',$this->getRequest()->getParam('branch'),'office_link')) {
                
                $form->getElement('branch')->setValue($branch['id']);
                
                $metatagService->setCustomViewMetatags(array(
                    'pl' => array(
                        'title' => 'Dodaj opinie - '.$agent['name'].' '.$branch['office_name'],
                        'description' => 'Korzystałeś z usług firmy '.$agent['name'].'? Oceń oddział firmy w '.$branch['town']
                    ),
                    'en' => array(
                        'title' => 'Add review for '.$agent['name'].' '.$branch['office_name'],
                        'description' => 'Did you use '.$agent['name'].'? Rate review for '.$branch['town'].' branch of '.$agent['name']
                    )
                ),$this->view);
                
            }
        }
        
        $form->getElement('agent_id')->setValue($agent['id']);
        
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($_POST)) {
                
                $values = $form->getValues();
                
                if(strlen($values['other_branch'])){
                    $branch = $branchService->saveNewBranchFromReview($values['agent_id'],$values['other_branch']);
                    $values['branch_id'] = $branch['id'];
                }
                else{
                    $values['branch_id'] = $values['branch'];
                }
                
                if($values['staff1_id']=='new'){
                    $staff1 = $staffService->saveNewStaffFromReview($values['staff1'],$values['agent_id'],$values['branch']);
                    $values['staff'] = $staff1['id'];
                }
                else{
                    $values['staff'] = $values['staff1_id'];
                }
                
                if($values['staff2_id']=='new'){
                    $staff2 = $staffService->saveNewStaffFromReview($values['staff2'],$values['agent_id'],$values['branch']);
                    $values['staff2'] = $staff2['id'];
                }
                else{
                    $values['staff2'] = $values['staff2_id'];
                }
                $values['activation_code'] = MF_Text::createUniqueToken();
                
                $review = $reviewService->saveNewTempReview($values);
                
                $options = $this->getFrontController()->getParam('bootstrap')->getOptions();
        
                $mail = new Zend_Mail('UTF-8');
                $mail->setSubject($this->view->translate('Activate your review of '.$review['Agent'].' at '));
                $mail->addTo($values['email'], $values['firstname'] . ' ' . $values['lastname']);
                $mail->setReplyTo($options['reply_email'], 'Pracownik');
               
                $mailService->sendActivationEmail($review,$mail, $this->view);
                
                
                $this->_helper->redirector->gotoRoute(array('type' => 'review'), 'domain-thank-you');
                
            }
        }
        
        $this->view->assign('agent',$agent);
        $this->view->assign('form',$form);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->_helper->layout->setLayout('page');
    }
    
    public function addUnlistedAction(){
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $reviewService = $this->_service->getService('Review_Service_Review');
        $staffService = $this->_service->getService('Staff_Service_Staff');
        $mailService = $this->_service->getService('User_Service_Mail');
        
        $agentForm = new Agent_Form_Agent();
        
        $form = new Review_Form_Review();
        
          $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Dodaj opinie o nowej firmie' 
            ),
            'en' => array(
                'title' => 'Add review for new company'
            )
        ),$this->view);
        
        $agentCategories = $agentService->getMainCategories();

        $this->view->assign('agentCategories',$agentCategories);

        $this->view->headMeta()->appendName('robots', 'noindex, nofollow');
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())&&$agentForm->isValid($this->getRequest()->getParams())) {
                
                $values = $form->getValues();
                
                $agentValues = $agentForm->getValues();
                
                
                $agent = $agentService->saveNewAgentFromReview($agentValues);
                $branch = $branchService->saveNewAgentBranchFromReview($agent['id'],$agentValues);
                
                $values['agent_id'] = $agent['id'];
                $values['branch_id'] = $branch['id'];
                $values['branch'] = $branch['id'];
                
                if($values['staff1_id']=='new'){
                    $staff1 = $staffService->saveNewStaffFromReview($values['staff1'],$values['agent_id'],$values['branch']);
                    $values['staff'] = $staff1['id'];
                }
                else{
                    $values['staff'] = $values['staff1_id'];
                }
                
                if($values['staff2_id']=='new'){
                    $staff2 = $staffService->saveNewStaffFromReview($values['staff2'],$values['agent_id'],$values['branch']);
                    $values['staff2'] = $staff2['id'];
                }
                else{
                    $values['staff2'] = $values['staff2_id'];
                }
                $values['activation_code'] = MF_Text::createUniqueToken();
                $review = $reviewService->saveNewTempReview($values);
                
                $options = $this->getFrontController()->getParam('bootstrap')->getOptions();
        
                $mail = new Zend_Mail('UTF-8');
                $mail->setSubject($this->view->translate('Activate your review of '.$review['Agent']['name'].' at '));
                $mail->addTo($values['email'], $values['firstname'] . ' ' . $values['lastname']);
                $mail->setReplyTo($review,$options['reply_email'], 'Pracownik');
               
                $mailService->sendActivationEmail($review,$mail, $this->view);
                
                $this->_helper->redirector->gotoRoute(array('type' => 'review'), 'domain-thank-you');
                
            }
            else{
                var_dump($form->getMessages());exit;
                
            }
        }
        
        $this->view->assign('agentForm',$agentForm);
        $this->view->assign('form',$form);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->_helper->layout->setLayout('page');
    }
    
    
    public function activateAction(){
        
        $reviewService = $this->_service->getService('Review_Service_Review');
        
        
        if(!$review = $reviewService->getTempReview($this->getRequest()->getParam('token'),'activation_code')) {
            throw new Zend_Controller_Action_Exception('Review not found');
        }
        $reviewService->activate($review);
        
        $this->_helper->redirector->gotoRoute(array('type' => 'activate'), 'domain-thank-you');
        
        
    }
    
    
    public function activateCommentAction(){
        
        $commentService = $this->_service->getService('Review_Service_Comment');
        
        
        if(!$comment = $commentService->getComment($this->getRequest()->getParam('token'),'activation_code')) {
            throw new Zend_Controller_Action_Exception('Comment not found');
        }
        $commentService->activate($comment);
        
        $this->_helper->redirector->gotoRoute(array('type' => 'activate-comment'), 'domain-thank-you');
        
        
    }
    
    public function selectCompanyAction(){
        $this->_helper->layout->setLayout('page');
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Dodaj opinie',
                'description' => 'Wybierz firmę z której usług korzystałeś. Dodaj opinie o firmie.'
            ),
            'en' => array(
                'title' => 'Add review for Polish company',
                'description' => 'Select Polish company which you used. Review Polish companies.'
            )
        ),$this->view);
        
        if(isset($_GET['agent_name'])){
            
            $agentService = $this->_service->getService('Agent_Service_Agent');

            if(!$agent = $agentService->getAgent($_GET['agent_name'],'id')) {
                throw new Zend_Controller_Action_Exception('Agent not found');
            }
            
            $this->_helper->redirector->gotoRoute(array('agent' => $agent['link']), 'domain-add-review');
            
        }
        
        $form2 = new Agent_Form_SelectAgent();
        
        $this->view->assign('form2',$form2);
    }
    
    
}

