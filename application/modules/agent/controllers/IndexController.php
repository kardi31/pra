<?php

/**
 * Banner_IndexController
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_IndexController extends MF_Controller_Action {
 
    
     public function init() {
        $this->_helper->ajaxContext()
                ->addActionContext('find-agent', 'json')
                ->initContext();
        parent::init();
    }
    
    public function detailsAction(){
        
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->_helper->layout->setLayout('page');
        
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $reviewService = $this->_service->getService('Review_Service_Review');
        
        if(!$agent = $agentService->getAgent($this->getRequest()->getParam('slug'),'link')) {
            throw new Zend_Controller_Action_Exception('Agent not found');
        }
        
        $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
        if(!$pageWasRefreshed ) {
           $agent->increaseView();
        }
        
        if(count($agent['Branches'])==1){
            $this->_helper->redirector->gotoUrl($this->view->url(array('slug' => $agent['Branches'][0]['office_link'],'agent' => $agent['link']),'domain-branch-details'));
        }
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => $agent['name'].' - Opinie o firmie',
                'description' => 'Przeczytaj opinie klientów o firmie '.$agent['name']
            ),
            'en' => array(
                'title' => $agent['name'].' - customer reviews',
                'description' => 'Read customer reviews of '.$agent['name']
            )
        ),$this->view);
        
        
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
        
        $this->view->assign('agent',$agent);
    }
    
    public function reviewsAction(){
        
    }
    
    public function contactAction(){
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->_helper->layout->setLayout('page');
        
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $mailService = $this->_service->getService('User_Service_Mail');
        
        if(!$agent = $agentService->getAgent($this->getRequest()->getParam('slug'),'link')) {
            throw new Zend_Controller_Action_Exception('Agent not found');
        }
        
        $form = new Agent_Form_Contact();
        
        $form->getElement('branch_id')->setMultiOptions($branchService->prependBranchesValues($agent['id']));
        
        if(count($agent['Branches'])==1){
            $this->_helper->redirector->gotoUrl($this->view->url(array('slug' => $agent['Branches'][0]['office_link'],'agent' => $agent['link']),'domain-branch-details'));
        }
        
        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $apikeys = $config->getOption('apikeys');
        $form->addElement('Recaptcha', 'g-recaptcha-response', [
            'siteKey' => $apikeys['google']['siteKey'],
            'secretKey' => $apikeys['google']['secretKey']
        ]);
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Skontaktuj się z firmą'.$agent['name'],
                'description' => 'Napisz wiadomość do firmy '.$agent['name']
            ),
            'en' => array(
                'title' => 'Contact '.$agent['name'],
                'description' => 'Write a message to '.$agent['name']
            )
        ),$this->view);
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                $values = $form->getValues();
                
                if(!$branch = $branchService->getBranch($values['branch_id'],'id')) {
                    throw new Zend_Controller_Action_Exception('Branch not found');
                }
                
                if(isset($_SESSION['contact_agent'][$branch['id']])){
                    $lastMessageTime = $_SESSION['contact_agent'][$branch['id']];
                    if(time() - $_SESSION['contact_agent'][$branch['id']] < 300){
                         $this->_helper->getHelper('FlashMessenger')->setNamespace('error')->addMessage($this->view->translate('You can send a message to certain branch only once every 5 minutes.'));
                         $this->_helper->redirector->gotoUrl($this->view->url(array('slug' => $agent['link']),'domain-agent-details'));
                    }
                }
                
                $options = $this->getFrontController()->getParam('bootstrap')->getOptions();
                $mail = new Zend_Mail('UTF-8');
                $mail->setSubject($this->view->translate('You have new customer enquiry from Rate Pole'));
                $mail->addTo($branch['email'], $branch['Agent']['name']." ".$branch['office_name']);
                $mail->setReplyTo($values['mail'], $values['firstname']." ".$values['lastname']);

                $mailService->sendBranchContactMail($values,$branch,$mail, $this->view);
                
                $_SESSION['contact_agent'][$branch['id']] = time();
                
                $this->_helper->getHelper('FlashMessenger')->setNamespace('success')->addMessage($this->view->translate('Thank you. Your message has been sent to ').$agent['name'].$this->view->translate('. They will contact you soon.'));

                $this->_service->get('doctrine')->getCurrentConnection()->commit();

                $this->_helper->redirector->gotoUrl($this->view->url(array('slug' => $agent['link']),'domain-agent-details'));
                
            }
        }
        
        $this->view->assign('form',$form);
        $this->view->assign('agent',$agent);
    }
    
    
    public function findAgentAction(){
        
        $this->_helper->layout->setLayout('page');
        
        $agentService = $this->_service->getService('Agent_Service_Agent');
        
        $query = $this->getRequest()->getParam('q');
        $agents = $agentService->findAgents($query,100,$this->view->language,Doctrine_Core::HYDRATE_ARRAY);
        
        $result = array(
            'total_count' => count($agents),
            'items' => $agents
        );
        $this->_helper->json($result);
        
    }
    
    
    public function addAction(){
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $updateService = $this->_service->getService('Agent_Service_Update');
        $agentService = $this->_service->getService('Agent_Service_Agent');
        
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        
        $form = new Agent_Form_Agent();
        
        $hoursForm = new Branch_Form_OpeningHours();
        
        $form->addSubForm($hoursForm, 'hoursForm');
        
        $agentCategories = $agentService->getMainCategories();

        $this->view->assign('agentCategories',$agentCategories);
        
        
        if($this->getRequest()->getParam('id')){
            if(!$update = $updateService->getUpdate($this->getRequest()->getParam('id'))) {
                throw new Zend_Controller_Action_Exception('Update not found');
            }
            
            $metatagService->setCustomViewMetatags(array(
                'pl' => array(
                    'title' => 'Dodaj kolejny oddział',
                    'description' => 'Zarejestruj swoja firmę w Oceń Fachowca'
                ),
                'en' => array(
                    'title' => 'Add another branch',
                    'description' => 'Register your company on Rate Pole'
                )
            ),$this->view);
            
            $form->getElement('name')->setRequired(false);
            $this->view->headMeta()->appendName('robots', 'noindex, nofollow');
            $this->view->assign('update',$update);
        }
        else{
            $metatagService->setCustomViewMetatags(array(
                'pl' => array(
                    'title' => 'Dodaj firmę',
                    'description' => 'Zarejestruj swoja firmę w Oceń Fachowca'
                ),
                'en' => array(
                    'title' => 'Add company',
                    'description' => 'Register your company on Rate Pole'
                )
            ),$this->view);
            
            $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
            $apikeys = $config->getOption('apikeys');
            $form->addElement('Recaptcha', 'g-recaptcha-response', [
                'siteKey' => $apikeys['google']['siteKey'],
                'secretKey' => $apikeys['google']['secretKey']
            ]);
        }
       
        
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                $values = $form->getValues();
                unset($values['id']);
                if(isset($update)){
                    $values['update_id'] = $update['id'];
                }
                $update = $updateService->saveUpdateFromArray($values);
                $values['hoursForm']['update_id'] = $update['id'];
                $updateService->saveOpeningHoursFromArray($values['hoursForm']);
                $this->_helper->getHelper('FlashMessenger')->setNamespace('success')->addMessage($this->view->translate('Thank you. Your update has been passed to the moderator. We will notify you when your changes has been approved.'));

                $this->_service->get('doctrine')->getCurrentConnection()->commit();

                $this->_helper->redirector->gotoUrl($this->view->url(array('id' => $update['id']),'domain-agent-update-thank-you'));
                
            }
        }
        
        $this->view->assign('form',$form);
        
        $this->_helper->layout->setLayout('page');
        if($this->getRequest()->getParam('id')){
            $this->renderScript('index/add-branch.phtml');
        }
    }
    
    public function updateThankYouAction(){
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $updateService = $this->_service->getService('Agent_Service_Update');
        
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Firma dodana - dziękujemy',
                'description' => 'Dziękujemy za dodanie Twojej firmy w Oceń Fachowca'
            ),
            'en' => array(
                'title' => 'Company added - thank you',
                'description' => 'Thank you for adding your company on Rate Pole'
            )
        ),$this->view);
        
        $this->view->headMeta()->appendName('robots', 'noindex, nofollow');
        
        if(!$update = $updateService->getUpdate($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Update not found');
        }
        else{
            $id = $update['id'];
            if($update['update_id']){
                $id = $update['Update']['id'];
            }
        }
       
        
        $this->view->assign('id',$id);
        
        $this->_helper->layout->setLayout('page');
    }
    
}

