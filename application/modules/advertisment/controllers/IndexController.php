<?php

/**
 * Advertisment_IndexController
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class Advertisment_IndexController extends MF_Controller_Action {
 
    public static $articleItemCountPerPage = 10;
    
    public function indexAction(){}
    
    public function searchAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        
        $groupService = $this->_service->getService('Advertisment_Service_Group');
        $groups = $groupService->getFullGroups($this->view->language,Doctrine_Core::HYDRATE_ARRAY);
        $search = $this->getRequest()->getParam('search_name');
        $search = $this->view->escape($search);
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Ogłoszenia dla fachowców',
                'description' => 'Popularne ogłoszenia dla pracowników'
            ),
            'en' => array(
                'title' => 'Search for Polish advertisments',
                'description' => 'Read advertisments for Polish employees'
            )
        ),$this->view);
        
        
        if(isset($_GET['submit'])){
            $search = filter_var($_GET['search'],FILTER_SANITIZE_STRING);
            $area = filter_var($_GET['area'],FILTER_SANITIZE_STRING);
            $searchResults = $advertismentService->findAdvertisment($search,$area,$this->view->language,Doctrine_Core::HYDRATE_ARRAY);
            
            
            $this->_helper->viewRenderer('index/search-result', null, true);

            $this->view->assign('searchResults',$searchResults);
            $this->view->assign('search',$search);
            $this->view->assign('area',$area);
        }
        
        
        
        $this->view->assign('groups', $groups);
        $this->view->assign('search', $search);
        
        $this->_helper->layout->setLayout('page');
        
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
    public function lastAdvertismentAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $lastAdvertisment = $advertismentService->getLastAdvertisment(6,Doctrine_Core::HYDRATE_ARRAY);
        $this->view->assign('lastAdvertisment', $lastAdvertisment);
        $this->_helper->viewRenderer->setResponseSegment('lastAdvertisment');
    }
    
    public function breakingAdvertismentAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        
        $breakingAdvertisment = $advertismentService->getBreakingAdvertisment(Doctrine_Core::HYDRATE_ARRAY);
        $this->view->assign('breakingAdvertisment', $breakingAdvertisment);
        
        
        $this->_helper->viewRenderer->setResponseSegment('breakingAdvertisment');
    }
    
    public function lastCategoriesAdvertismentAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $categoryService = $this->_service->getService('Advertisment_Service_Category');
        
        
        $categories = $categoryService->getAllCategories();
        $advertismentList = array();
        foreach($categories as $category):
            if($category['title'] == "Reportaże")
                continue;
            $advertismentList[$category['title']] = $advertismentService->getLastCategoryAdvertisment($category['id'],6,Doctrine_Core::HYDRATE_ARRAY);
        endforeach;
        
        $this->view->assign('advertismentList', $advertismentList);
        
        
        $this->_helper->viewRenderer->setResponseSegment('lastCategoriesAdvertisment');
    }
    
    
    public function addAdvertismentAction(){
        $this->_helper->layout->setLayout('page');
        
        $groupService = $this->_service->getService('Advertisment_Service_Group');
        $categoryService = $this->_service->getService('Advertisment_Service_Category');
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        $groupAndCategories = $groupService->getGroupsAndCategories($this->view->language,Doctrine_Core::HYDRATE_ARRAY);
        $this->view->assign('groupAndCategories',$groupAndCategories);
        
         $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        
        $authService = $this->_service->getService('User_Service_Auth');
        $user = $authService->getAuthenticatedUser();
            
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Dodaj darmowe ogłoszenie dla pracowników',
                'description' => 'Dodaj nowe ogłoszenie'
            ),
            'en' => array(
                'title' => 'Add new advertisment for Polish employees',
                'description' => 'New advertisments for Polish employees'
            )
        ),$this->view);
        
        if($this->getRequest()->getParam('category')){
            
            $category = $categoryService->getFullCategory($this->getRequest()->getParam('category'),'slug',$this->view->language);
            
            
            $this->view->headMeta()->appendName('robots', 'noindex, nofollow');
            
            
            $this->view->assign('category',$category);
            
            $form = new Advertisment_Form_Advertisment();
            
            if($this->getRequest()->isPost()) {
//                Zend_Debug::dump($this->getRequest()->getParams());exit;
                if($form->isValid($this->getRequest()->getParams())) {
                    try {
                        $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                        $values = $form->getValues();
                        $values['category_id'] = $category->get('id');
                        $values['publish'] = 0;
                        $values['user_id'] = $user->get('id');
                        $values['last_user_id'] = $user->get('id');
                        
                        
                        $values['Translation']['pl'] = array('title' => $values['title'],'content' => $values['content']);
                        $values['Translation']['en'] = $values['Translation']['pl'];
                       
                        $advertisment = $advertismentService->saveAdvertismentFromArray($values);
                       
                        $photoRoot = $photoService->createPhotoRoot();
                        $advertisment->set('PhotoRoot',$photoRoot);
                        $advertisment->save();
                        if($photoRoot) {
                            
                            
                            $options = $this->getInvokeArg('bootstrap')->getOptions();
                            
                            foreach($values['photos'] as $photo_name){
                                
                                $filePath = urldecode($options['publicDir'] . '/media/temp/'.$photo_name);
                                $photoService->createPhotoFromTemp($filePath, "new".$photo_name, "new".$photo_name, array_keys(Advertisment_Model_Doctrine_Advertisment::getAdvertismentPhotoDimensions()), $photoRoot, false);
                            }
                        }
                        $this->_service->get('doctrine')->getCurrentConnection()->commit();
                
//                        $this->view->messages()->add($translator->translate('Item has been added'), 'success');


                        $this->_helper->redirector->gotoUrl($this->view->url(array(), 'domain-advertisment-confirm'));
                    } catch(Exception $e) {
                        $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                        $this->_service->get('log')->log($e->getMessage(), 4);
                    }
                }
            }
            
            
            $this->view->assign('form',$form);
            
            $this->_helper->viewRenderer('index/add-advertisment-step2', null, true);
        }
        
        
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
    public function editAdvertismentAction(){
        
        $this->_helper->layout->setLayout('page');
        
        $groupService = $this->_service->getService('Advertisment_Service_Group');
        $categoryService = $this->_service->getService('Advertisment_Service_Category');
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        $advertisment = $advertismentService->getAdvertisment($this->getRequest()->getParam('id'));
        
        
        $groupAndCategories = $groupService->getGroupsAndCategories(Doctrine_Core::HYDRATE_ARRAY);
        $this->view->assign('groupAndCategories',$groupAndCategories);
        
         $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        
        $authService = $this->_service->getService('User_Service_Auth');
        $user = $authService->getAuthenticatedUser();
            
            
            
            $form = $advertismentService->getAdvertismentForm($advertisment);
            
            $form->removeElement('finish_date');
            $form->getElement('submit')->setLabel('Edytuj ogłoszenie');
            
            if($this->getRequest()->isPost()) {
//                Zend_Debug::dump($this->getRequest()->getParams());exit;
                if($form->isValid($this->getRequest()->getParams())) {
                    try {
                        $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                        $values = $form->getValues();
                        $values['id'] = $advertisment['id'];
                        $values['last_user_id'] = $user->get('id');
                        
                        $advertisment = $advertismentService->saveAdvertismentFromArray($values);
                      
                       
                        
                        $this->_service->get('doctrine')->getCurrentConnection()->commit();


                        $this->_helper->redirector->gotoUrl($this->view->url(array('action' => 'my-ads'), 'domain-account'));
                    } catch(Exception $e) {
                        var_dump($e->getMessage());exit;
                        $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                        $this->_service->get('log')->log($e->getMessage(), 4);
                    }
                }
            }
            
            
            $this->view->assign('form',$form);
            
        
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
    
    public function directoryAction() {
        $companyService = $this->_service->getService('Advertisment_Service_Advertisment');
        $categoryService = $this->_service->getService('Advertisment_Service_Category');
        
        
        if(!$category = $categoryService->getFullCategory($this->getRequest()->getParam('category'), 'slug', $this->view->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Category not found');
        }
        
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => $category['Translation'][$this->view->language]['title'].' - Ogłoszenia dla fachowców',
                'description' => 'Ogłoszenia dla pracowników w kategorii '.$category['Translation'][$this->view->language]['title']
            ),
            'en' => array(
                'title' => $category['Translation'][$this->view->language]['title'].' advertisments - Search for Polish advertisments',
                'description' => 'Read advertisments for Polish employees in category '.$category['Translation'][$this->view->language]['title']
            )
        ),$this->view);
        
         $query = $companyService->getCategoryAdvertismentsQuery($category['id']);

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(self::$articleItemCountPerPage);
        
        $this->view->assign('paginator', $paginator);
        
        $this->view->assign('category', $category);
        
        $this->_helper->layout->setLayout('page');
        
        $this->_helper->actionStack('layout', 'index', 'default');
        
    }
    
    
    public function lastAdsAction(){
        
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        
        $lastAds = $advertismentService->getLastAdvertisment(6,Doctrine_Core::HYDRATE_ARRAY);
        $this->view->assign('lastAds',$lastAds);
    }
    
    public function lastJobAdsAction(){
        
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        
        $lastAds = $advertismentService->getLastCategoryAdvertisment(1,8);
        
        
        
        $this->view->assign('lastAds',$lastAds);
        $this->_helper->viewRenderer->setResponseSegment('lastJobAds');
    }
    
    public function lastSellCarAdsAction(){
        
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        
        $lastAds = $advertismentService->getLastCategoryAdvertisment(12,8);
        
        
        
        $this->view->assign('lastAds',$lastAds);
        $this->_helper->viewRenderer->setResponseSegment('lastSellCarAds');
    }
    
    public function listAdvertismentAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $categoryService = $this->_service->getService('Advertisment_Service_Category');
        
        
        $categories = $categoryService->getAllCategories();
        
        $lastAdvertisment = $advertismentService->getLastAdvertisment(3,Doctrine_Core::HYDRATE_ARRAY);
        
        $advertismentList = array();
        foreach($categories as $category):
            $advertismentList[$category['title']] = $advertismentService->getLastCategoryAdvertisment($category['id'],2,Doctrine_Core::HYDRATE_ARRAY);
        endforeach;
        
        
        $this->view->assign('lastAdvertisment', $lastAdvertisment);
        $this->view->assign('advertismentList', $advertismentList);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $this->_helper->layout->setLayout('article');
    }
    
    public function advertismentConfirmAction(){
        
        $this->_helper->layout->setLayout('page');
        
        $this->view->headMeta()->appendName('robots', 'noindex, nofollow');
        
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Ogłoszenie dodane'
            ),
            'en' => array(
                'title' => 'Advertisment added'
            )
        ),$this->view);
        
        
    }
    
    public function listAdvertismentCategoryAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $categoryService = $this->_service->getService('Advertisment_Service_Category');
        
        
        if(!$category = $categoryService->getFullCategory($this->getRequest()->getParam('category'), 'slug', $this->view->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Category not found');
        }
        
       $advertismentList = $advertismentService->getLastCategoryAdvertisment($category['id'],null,Doctrine_Core::HYDRATE_ARRAY);
        
        
        $this->view->assign('category', $category);
        $this->view->assign('advertismentList', $advertismentList);
        
        $this->_helper->layout->setLayout('article');
        
        $this->_helper->actionStack('layout', 'index', 'default');
        
        
    }
    
    
    
    public function categoryAction(){
        
        $this->_helper->layout->setLayout('article');
        $this->_helper->actionStack('layout', 'index', 'default');
        
        
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $categoryService = $this->_service->getService('Advertisment_Service_Category');
        
        if(!$category = $categoryService->getFullCategory($this->getRequest()->getParam('slug'), 'slug',$this->view->language)) {
            throw new Zend_Controller_Action_Exception('Category not found', 404);
        }
        
        if(!$page = $pageService->getPage($this->getRequest()->getParam('slug'), 'type')) {
            
        }
        
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        $metatagService->setViewMetatags(array('title' => $category['title']." - Ogłoszenia Polaków w Wielkiej Brytanii"),$this->view);
        
         $query = $advertismentService->getCategoryPaginationQuery($category['id'],$this->language);

        $adapter = new MF_Paginator_Adapter_Doctrine($query, Doctrine_Core::HYDRATE_ARRAY);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($this->getRequest()->getParam('page', 1));
        $paginator->setItemCountPerPage(self::$articleItemCountPerPage);
        
        $this->view->assign('paginator', $paginator);
       
        
        $metatagService->setViewMetatags($page['metatag_id'],$this->view);
        
        
         $this->view->assign('paginator', $paginator);
         $this->view->assign('category', $category);
        
    }
    
    public function groupAction(){
        
        $this->_helper->layout->setLayout('article');
        $this->_helper->actionStack('layout', 'index', 'default');
        
        
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $groupService = $this->_service->getService('Advertisment_Service_Group');
        
        if(!$group = $groupService->getGroup($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Group not found', 404);
        }
        
        if(!$page = $pageService->getPage($this->getRequest()->getParam('slug'), 'type')) {
            
        }
        
        $metatagService->setViewMetatags($page['metatag_id'],$this->view);
        
        $advertismentList = $advertismentService->getGroupAdvertisment($group['id'],Doctrine_Core::HYDRATE_ARRAY);
        
         $this->view->assign('advertismentList', $advertismentList);
         $this->view->assign('group', $group);
        
    }
    
    public function tagAction(){
        
        $this->_helper->layout->setLayout('article');
        $this->_helper->actionStack('layout', 'index', 'default');
        
        
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $tagService = $this->_service->getService('Advertisment_Service_Tag');
        
        if(!$tag = $tagService->getTag($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Tag not found', 404);
        }
        
        
        $metatagService->setViewMetatags($tag['metatag_id'],$this->view);
        
        $advertismentList = $advertismentService->getTagAdvertisment($tag['id'],Doctrine_Core::HYDRATE_ARRAY);
        
         $this->view->assign('advertismentList', $advertismentList);
         $this->view->assign('tag', $tag);
        
    }
    
     public function studentAction(){
        
        $this->_helper->layout->setLayout('article');
        $this->_helper->actionStack('layout', 'index', 'default');
        
        
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
         if(!$page = $pageService->getPage('studencka-tworczosc', 'type')) {
            
        }
        
        $metatagService->setViewMetatags($page['metatag_id'],$this->view);
                
        $advertismentList = $advertismentService->getStudentAdvertisment(Doctrine_Core::HYDRATE_ARRAY);
        
         $this->view->assign('advertismentList', $advertismentList);
        
    }
    
    public function articleAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $adService = $this->_service->getService('Banner_Service_Ad');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $settingsService = $this->_service->getService('Default_Service_Setting');

        if(!$article = $advertismentService->getFullArticle($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Article not found', 404);
        }
       
        $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';

        if(!$pageWasRefreshed ) {
           $article->increaseView();
        } 
        
        
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $premiumAgents = $agentService->getRandomPremiumAgents();
        $popularAgents = $agentService->getMostPopularAgents();
        
        
        $this->view->assign('premiumAgents', $premiumAgents);
        $this->view->assign('popularAgents', $popularAgents);
        
        
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => $article['Translation'][$this->view->language]['title'],
                'description' => $article['Translation'][$this->view->language]['content']
            ),
            'en' => array(
                'title' => $article['Translation'][$this->view->language]['title'],
                'description' => $article['Translation'][$this->view->language]['content']
            )
        ),$this->view);
        $metatagService->setOgMetatags($this->view,$article['Translation'][$this->view->language]['title'],'/media/photos/'.$article['Photos'][1]['offset']."/".$article['Photos'][1]['filename'],$article['Translation'][$this->view->language]['content']);
    
        $this->view->assign('article', $article);
        
        $form = new Default_Form_Contact();
        $form->removeElement('firstName');
        $form->removeElement('lastName');
        $form->removeElement('email');
        $form->removeElement('subject');
        $form->removeElement('message');
        $form->removeElement('csrf');
        $captchaDir = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('captchaDir');
        $form->addElement('captcha', 'captcha',
            array(
            'label' => 'Rewrite the chars', 
            'captcha' => array(
                'captcha' => 'Image',  
                'wordLen' => 5,  
                'timeout' => 300,  
                'font' => APPLICATION_PATH . '/../data/arial.ttf',  
                'imgDir' => $captchaDir,  
                'imgUrl' => $this->view->serverUrl() . '/captcha/',  
            )
        ));
        
        
       $this->view->assign('form',$form);
        
       
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->_helper->layout->setLayout('page');
    }
    
    
     public function streamAction() {
        $streamService = $this->_service->getService('Advertisment_Service_Stream');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        if(!$stream = $streamService->getFullStream($this->getRequest()->getParam('slug'), 'slug')) {
            throw new Zend_Controller_Action_Exception('Stream not found', 404);
        }
       
        $metatagService->setViewMetatags($stream->get('Metatags'), $this->view);
        $metatagService->setOgMetatags($this->view,$stream['Translation'][$this->view->language]['title'],'',$stream['Translation'][$this->view->language]['content']);
       
        
        $this->view->assign('stream', $stream);
        
        
        $this->_helper->actionStack('layout', 'index', 'default');
        
        $this->_helper->layout->setLayout('article');
    }
    
    public function facebookAction(){
        
    }
    
}

