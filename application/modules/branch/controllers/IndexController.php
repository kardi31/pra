<?php

/**
 * News_IndexController
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_IndexController extends MF_Controller_Action {
 
    
    public function indexAction(){
        $this->_helper->layout->setLayout('page');
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $reviewService = $this->_service->getService('Review_Service_Review');
        
                
        if(!$branch = $branchService->getAgentBranch($this->getRequest()->getParam('agent'),'link',$this->getRequest()->getParam('slug'),'office_link')) {
            throw new Zend_Controller_Action_Exception('Branch not found');
        }
        
        $agent = $branch['Agent'];
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => $agent['name'].' '.$branch['office_name'].' - Opinie o firmie',
                'description' => 'Przeczytaj opinie klientów o firmie '.$agent['name'].' '.$branch['office_name']
            ),
            'en' => array(
                'title' => $agent['name'].' '.$branch['office_name'].' - customer reviews',
                'description' => 'Read customer reviews of '.$agent['name'].' '.$branch['office_name']
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
        
        
        $this->view->assign('paginator', $paginator);
        $this->view->assign('agent',$agent);
        $this->view->assign('branch',$branch);
    }
    
    public function searchAction(){
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $this->_helper->layout->setLayout('page');
        
       
        
    }
    
    public function areaSearchResultAction() {
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->_helper->layout->setLayout('page');
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $agentService = $this->_service->getService('Agent_Service_Agent');
        
        $filters = $this->getRequest()->getParams();
        if(!(strlen($filters['area'])||strlen($filters['search'])||strlen($filters['name'])||strlen($filters['category'])||!empty($filters['category']))){
            $metatagService = $this->_service->getService('Default_Service_Metatag');
            $metatagService->setCustomViewMetatags(array(
                'pl' => array(
                    'title' => 'Wyszukaj firmę',
                    'description' => 'Znajdź fachowców w Twoim regionie. Wyszukaj najlepsze firmy w ocenie konsumentów'
                ),
                'en' => array(
                    'title' => 'Find Polish company',
                    'description' => 'Search for best Polish companies according to consumers.'
                )
            ),$this->view);

            $agentService = $this->_service->getService('Agent_Service_Agent');
            $form = new Branch_Form_RankingSearch();

            $form->getElement('category_id')->addMultiOption('','');
            $form->getElement('category_id')->addMultiOptions($agentService->prependMainCategories($this->view->language,false));
            $form->getElement('category_id')->setName('category');
            $this->view->assign('form',$form);

            $agentCategories = $agentService->getMainCategories();

            $this->view->assign('agentCategories',$agentCategories);
            
            $this->render('search');
        }
        else{
        
            $searchString = $this->getRequest()->getParam('search');
            if(!strlen($searchString)){
                $searchString = $this->getRequest()->getParam('area');
            }
            $searchName = $this->getRequest()->getParam('name');
    //        
            $sort = $this->getRequest()->getParam('sort');
    //        
            $page = $this->getRequest()->getParam('page', 1);
            $query = $branchService->searchAreaQuery($searchString,$searchName,$filters,$sort);
    //
            $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_RECORD);
            $paginator = new Zend_Paginator($adapter);
            $paginator->setCurrentPageNumber($page);
            $paginator->setItemCountPerPage(30);
            $filterCount = $branchService->searchAreaCount($searchString,$searchName,$filters,Doctrine_Core::HYDRATE_ARRAY);

            $form = new Branch_Form_Search();

            $areas = MF_Text::getAreas();
            $categories = $agentService->getMainCategories();
            
            $searchCategories = $_GET['category'];
            
            $fullSearchCategories = array();
            foreach($searchCategories as $searchCategory):
                $searchCategory = $agentService->getCategory($searchCategory,'id');
                if($searchCategory)
                    $fullSearchCategories[] = $searchCategory;
            endforeach;
            
            if($this->getRequest()->getParam('categoryslug')){
                $searchCategory = $agentService->getFullCategory($this->getRequest()->getParam('categoryslug'),'slug',$this->view->language);
                if($searchCategory){
                    $searchCategories[] = $searchCategory['id'];
                    $fullSearchCategories[] = $searchCategory;
                }
                        
            }


            $metatagService = $this->_service->getService('Default_Service_Metatag');
            $metatagService->setCustomViewMetatags(array(
                'pl' => array(
                    'title' => 'Znajdź fachowca w '.ucwords($searchString),
                    'description' => 'Wyszukaj najlepsze firmy w ocenie konsumentów - '.ucwords($searchString)
                ),
                'en' => array(
                    'title' => 'Find Polish companies in '.ucwords($searchString),
                    'description' => 'Search for best Polish companies in'.ucwords($searchString)
                )
            ),$this->view);
            
            $this->view->headLink(array('rel' => 'canonical', 'href' => $this->view->url(array('area' => $searchString),'domain-area-search-result')));
            if ($paginator->getPages()->previous){
                $this->view->headLink(array('rel' => 'prev', 'href' => $this->view->url(array('area' => $searchString),'domain-area-search-result')."?page=".$paginator->getPages()->previous));
            }
            if ($paginator->getPages()->next){
                $this->view->headLink(array('rel' => 'next', 'href' => $this->view->url(array('area' => $searchString),'domain-area-search-result')."?page=".$paginator->getPages()->next));
            }
            
            
            $this->view->assign('categories', $categories);
            $this->view->assign('paginator', $paginator);

            $this->view->assign('form',$form);
            $this->view->assign('areas',$areas);
            $this->view->assign('page',$page);
            $this->view->assign('filterCount',$filterCount);
            $this->view->assign('searchString',$searchString);
            $this->view->assign('searchCategories',$searchCategories);
            $this->view->assign('searchName',$searchName);
            $this->view->assign('fullSearchCategories',$fullSearchCategories);
            
        }
    }
    
    
    public function rankingIndexAction() {
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->_helper->layout->setLayout('page');
        $agentService = $this->_service->getService('Agent_Service_Agent');
        
        $form = new Branch_Form_RankingSearch();
        $form->getElement('category_id')->addMultiOptions($agentService->prependMainCategories($this->view->language));
        
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    
                    $data = $form->getValues();
                    
                    if(isset($data['category_id'])){
                        if(isset($data['area'])){
                            
                            $this->_helper->redirector->gotoUrl($this->view->url(array('region' => $data['area'],'category' => $data['category_id']),'domain-ranking-region-category'));
                        }
                        else{
                            $this->_helper->redirector->gotoUrl($this->view->url(array('category' => $data['category_id']),'domain-ranking-category'));
                            
                        }
                    }

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
        
        $categories = $agentService->getMainCategories();
        
        $this->view->assign('categories',$categories);
        $this->view->assign('form',$form);
    }
    
    public function rankingAction() {
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->_helper->layout->setLayout('page');
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $agentService = $this->_service->getService('Agent_Service_Agent');
        
        
        $route = Zend_Controller_Front::getInstance()->getRouter()->getCurrentRouteName();
        
        // town ranking
        if($route=='domain-ranking-region-category'){
            $region = $this->getRequest()->getParam('region');
            $categoryParam = $this->getRequest()->getParam('category');
            $branches = $branchService->rankBranchesByRegionAndCategory($region,$categoryParam,$this->view->language,Doctrine_Core::HYDRATE_RECORD);
            $category = $agentService->getFullCategory($categoryParam,'slug',$this->view->language);
        }
        elseif($route=='domain-ranking-category'){
            $categoryParam = $this->getRequest()->getParam('category');
            $branches = $branchService->rankBranchesByCategory($categoryParam,$this->view->language,Doctrine_Core::HYDRATE_RECORD);
            $category = $agentService->getFullCategory($categoryParam,'slug',$this->view->language);
            $region = false;
        }
        
        
        $form = new Branch_Form_RankingSearch();
        $form->getElement('category_id')->addMultiOptions($agentService->prependMainCategories($this->view->language));
        $form->getElement('category_id')->setValue($categoryParam);
        
        $form->getElement('area')->setValue(ucwords($region));
        
        $this->view->assign('branches',$branches);
        
        $this->view->assign('form',$form);
        $this->view->assign('region',$region);
        $this->view->assign('category',$category);
    
    }
    public function nextEventsAction(){
        echo "c";exit;
        $eventService = $this->_service->getService('District_Service_Event');
        
        $nextEvents = $eventService->getNextEvents();
        var_dump($nextEvents);exit;
        $this->view->assign('nextEvents',$nextEvents);
        
       // $this->_helper->viewRenderer->setNoRender();
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
