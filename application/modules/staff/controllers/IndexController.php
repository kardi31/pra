<?php

/**
 * News_IndexController
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Staff_IndexController extends MF_Controller_Action {
 
    
    public function indexAction(){
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->_helper->layout->setLayout('page');
        
        $staffService = $this->_service->getService('Staff_Service_Staff');
        $reviewService = $this->_service->getService('Review_Service_Review');
        
                
        if(!$staff = $staffService->getStaff($this->getRequest()->getParam('slug'),'link')) {
            throw new Zend_Controller_Action_Exception('Staff not found');
        }
        
        $query = $reviewService->getStaffReviewPaginationQuery($staff['id']);

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(30);
        $this->view->assign('paginator', $paginator);
        $this->view->assign('staff',$staff);
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => $staff['firstname'].' '.$staff['lastname'].' - Opinie o pracowniku',
                'description' => 'Opinie klientów o '.$staff['firstname'].' '.$staff['lastname']
            ),
            'en' => array(
                'title' => $staff['firstname'].' '.$staff['lastname'].' - customer reviews',
                'description' => 'Read customer reviews of '.$staff['firstname'].' '.$staff['lastname']
            )
        ),$this->view);
        
    }
    
    
    
    public function searchAction(){
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $staffService = $this->_service->getService('Staff_Service_Staff');
        $this->_helper->layout->setLayout('page');
        
        
         $form = new Branch_Form_RankingSearch();
        
        $form->getElement('name')->setLabel($this->view->translate('Staff name'));
        $form->getElement('area')->setLabel($this->view->translate('Company name'));
        $form->getElement('area')->setName('company');
        $this->view->assign('form',$form);
        
        
         if($this->getRequest()->isGet()&&isset($_GET['staffSearch'])) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    
                    $filters = array();
                    
                    $agent_name = $_GET['company'];
                    $staff_name = $_GET['name'];
                    $sort = $this->getRequest()->getParam('sort');
//        
                    $page = $this->getRequest()->getParam('page', 1);
                    $query = $staffService->searchStaffQuery($staff_name,$agent_name,$filters,$sort);

                    $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_RECORD);
                    $paginator = new Zend_Paginator($adapter);
                    $paginator->setCurrentPageNumber($page);
                    $paginator->setItemCountPerPage(30);
                    $filterCount = $staffService->searchStaffCount($staff_name,$agent_name,$filters,Doctrine_Core::HYDRATE_ARRAY);

                    $this->view->assign('paginator',$paginator);    
                    $this->view->assign('filterCount',$filterCount);  
                    $this->view->assign('agent_name',$agent_name);    
                    $this->view->assign('staff_name',$staff_name);     
                
                    $this->renderScript('index/staff-search-result.phtml');

                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
            else{
                $form->getMessages();exit;
            }
        }
        
        
    }
    
    
    public function areaSearchResultAction() {
        $this->_helper->layout->setLayout('page');
        $branchService = $this->_service->getService('Branch_Service_Branch');
        
        $searchString = $this->getRequest()->getParam('search');
        
        $filters = array();
        foreach($this->getRequest()->getParams() as $key => $param){
            if($param=='true'){
                $filters[] = $key;
            }
        }
        
        $sort = $this->getRequest()->getParam('sort');
        
        $page = $this->getRequest()->getParam('page', 1);
        $query = $branchService->searchAreaQuery($searchString,$filters,$sort);

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(30);
        $filterCount = $branchService->searchAreaCount($searchString,$filters,Doctrine_Core::HYDRATE_ARRAY);
        $this->view->assign('paginator', $paginator);
        
        $this->view->assign('page',$page);
        $this->view->assign('filterCount',$filterCount);
        $this->view->assign('searchString',$searchString);
    }
    
    
    public function updateStaffAction(){
        
         $staffService = $this->_service->getService('Staff_Service_Staff');
         $updateService = $this->_service->getService('Staff_Service_Update');
        
        if(!$staff = $staffService->getStaff((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Staff member not found');
        }
        
        $this->view->assign('staff',$staff);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->_helper->layout->setLayout('page');
        $form = new Staff_Form_UpdateStaff();
        
        
        $config = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        $apikeys = $config->getOption('apikeys');
        $form->addElement('Recaptcha', 'g-recaptcha-response', array(
            'siteKey' => $apikeys['google']['siteKey'],
            'secretKey' => $apikeys['google']['secretKey']
        ));
        
        $this->view->assign('form',$form);
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => $staff['firstname'].' '.$staff['lastname'].' - edytuj dane'
            ),
            'en' => array(
                'title' => $staff['firstname'].' '.$staff['lastname'].' - edit details'
            )
        ),$this->view);
        
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    
                    $values['staff_id'] = $staff->get('id');
                    
                    $updateService->saveUpdateFromArray($values);
                    
                    $this->_helper->getHelper('FlashMessenger')->setNamespace('success')->addMessage($this->view->translate('Thank you. Your update has been passed to the moderator. We will notify you when your changes has been approved.'));
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->url(array('slug' => $staff['link']),'domain-staff-profile'));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
      
    }
    
   public function articleAction() {
        $eventService = $this->_service->getService('District_Service_Event');
        $adService = $this->_service->getService('Banner_Service_Ad');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $settingsService = $this->_service->getService('Default_Service_Setting');
        
        if(!$event = $eventService->getFullEvent($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Event not found', 404);
        }
        $ad = $adService->getActiveAd($event['VideoRoot']['Ad']['id']);
       
        $lastServerId = $settingsService->getSetting('server',Doctrine_Core::HYDRATE_RECORD);
        
        $videoUrl = $event['VideoRoot']['url'];
        // jak nie vimeo i youtube
        if(strpos($videoUrl,'vimeo')==false && strpos($videoUrl,'youtube')==false){
            if($lastServerId->value==1){
                $videoUrl = str_replace('stream2', 'stream1', $videoUrl);
                $lastServerId->value = 2;
                $lastServerId->save();
            }
            elseif($lastServerId->value==2){
                $videoUrl = str_replace('stream1', 'stream2', $videoUrl);
                $lastServerId->value = 1;
                $lastServerId->save();
            }
        }
        
        $metatagService->setViewMetatags($event['metatag_id']);
               
        $otherEvents = $eventService->getOtherEvents($event,Doctrine_Core::HYDRATE_ARRAY);
        
      
        $this->view->assign('otherEvents', $otherEvents);
        $this->view->assign('article', $event);
     
       
       $this->view->assign('videoUrl',$videoUrl);
       $this->view->assign('ad',$ad);
       $this->view->assign('otherEvents',$otherEvents);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $this->_helper->layout->setLayout('article');
    }
    
     public function randomPersonAction(){
        $peopleService = $this->_service->getService('District_Service_People');
        
        $person = $peopleService->getRandomPerson();
        $this->view->assign('person',$person);
        
        
        $this->_helper->viewRenderer->setResponseSegment('randomPerson');
    }
    
    public function showPersonAction() {
        $peopleService = $this->_service->getService('District_Service_People');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        
        if(!$person = $peopleService->getFullPerson($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Person not found', 404);
        }
        
        
        $metatagService->setViewMetatags($person->get('Metatags'), $this->view);
       
        $this->view->assign('person', $person);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $this->_helper->layout->setLayout('article');
    }
    
    public function peopleListAction(){
        
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->_helper->layout->setLayout('article');
        
         $peopleService = $this->_service->getService('District_Service_People');
        
        
        if(!$people = $peopleService->getAllPeople($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Person not found', 404);
        }
        
        $this->view->assign('people', $people);
        
    }
    
    /* people - end */
    
    /* attraction - start */
    
    public function listAttractionAction() {
        $attractionService = $this->_service->getService('District_Service_Attraction');
        
        $attractions = $attractionService->getAllAttractions();
        
        $this->view->assign('attractions', $attractions);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $this->_helper->layout->setLayout('article');
    }
    
    public function showAttractionAction(){
        $attractonService = $this->_service->getService('District_Service_Attraction');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        if(!$attraction = $attractonService->getFullAttraction($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Attraction not found', 404);
        }
        
        $metatagService->setViewMetatags($attraction->get('Metatags'), $this->view);
       
        $this->view->assign('attraction', $attraction);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $this->_helper->layout->setLayout('article');
    }
}

