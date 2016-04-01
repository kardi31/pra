<?php

class Default_IndexController extends MF_Controller_Action
{
    
   public function indexAction(){
       $this->_helper->actionStack('layout');
       
       
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $branchService = $this->_service->getService('Branch_Service_Branch');
        
        
        
        if(!$category = $agentService->getFullCategory($_COOKIE['category'],'slug',$this->view->language)){
            $category = $agentService->getFullCategory(1,'id',$this->view->language);
        }
        
        $categoryBranches = $branchService->rankBranchesByCategory($category['Translation'][$this->view->language]['slug'],$this->view->language,Doctrine_Core::HYDRATE_RECORD,3);
        
        $geolocationData = var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR'])));
        $userTown = strlen($geolocationData['geoplugin_city'])?$geolocationData['geoplugin_city']:'London';
        
        $premiumBranches = $branchService->getRandomPremiumBranches();
        $bestTownBranches = $branchService->getBestTownBranches($userTown,3);
        $newestBranches = $branchService->getNewestBranches(3);
        
        
        
        
        $bannerService = $this->_service->getService('Banner_Service_Banner');
        
        $banner = $bannerService->getPositionBanners('Homepage');
        $banner = $banner[0];
        $this->view->assign('banner', $banner);
        
        
         $newsService = $this->_service->getService('News_Service_News');

        $lastNews = $newsService->getLastNews(6, Doctrine_Core::HYDRATE_ARRAY);

        $this->view->assign('lastNews', $lastNews);
        
        $this->view->assign('premiumBranches',$premiumBranches);
        $this->view->assign('bestTownBranches',$bestTownBranches);
        $this->view->assign('userTown',$userTown);
        $this->view->assign('category',$category);
        $this->view->assign('newestBranches',$newestBranches);
        $this->view->assign('categoryBranches',$categoryBranches);
        
        
        
        $form = new Branch_Form_RankingSearch();
        
        $form->getElement('category_id')->addMultiOption('','');
        $form->getElement('category_id')->addMultiOptions($agentService->prependMainCategories($this->view->language,false));
        $form->getElement('category_id')->setName('category');
        
        $form2 = new Agent_Form_SelectAgent();
        
        $this->view->assign('form',$form);
        $this->view->assign('form2',$form2);
        
   }
        
   public function searchAction(){
       $this->_helper->viewRenderer->setResponseSegment('search');
        $this->_helper->actionStack('layout', 'index', 'default');
   }     
   
   public function awardsAction(){
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->_helper->layout->setLayout('page');
   }     
        
//        var_dump(isset($this->view->nextEvents));exit;
    

    public function layoutAction()
    {
        
       
        $bannerService = $this->_service->getService('Banner_Service_Banner');
        $banners = $bannerService->getAllActiveBanners();
        $this->view->assign('banners', $banners);
        $this->_helper->actionStack('slider');
        $this->_helper->actionStack('menu');
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function thankYouAction(){
        $param = $this->getParam('type');
        $this->view->assign('param',$param);
                
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagService->setCustomViewMetatags(array(
            'pl' => array(
                'title' => 'Dziękujemy'
            ),
            'en' => array(
                'title' => 'Thank you'
            )
        ),$this->view);
        
        $this->view->headMeta()->appendName('robots', 'noindex, follow');
        
        
        $this->_helper->actionStack('layout');
        
        $this->_helper->layout->setLayout('page');
    }

    public function footerAction()
    {
        $this->_helper->viewRenderer->setResponseSegment('footer');
    }


     public function contactAction() {
        
        $this->_helper->layout->setLayout('page');
        
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $serviceService = $this->_service->getService('Default_Service_Service');
        
        
//        if(!$page = $pageService->getI18nPage('contact', 'type', $this->language, Doctrine_Core::HYDRATE_RECORD)) {
//            throw new Zend_Controller_Action_Exception('Page not found');
//        }
// 
        $contactEmail = $this->getInvokeArg('bootstrap')->getOption('contact_email');
        $mailerEmail = $this->getInvokeArg('bootstrap')->getOption('mailer_email');
        
//        if ($page != NULL):
//            $metatagService->setViewMetatags($page->get('Metatag'), $this->view);
//        endif;
        $form = new Default_Form_ContactPage();
//        
//	$form->getElement('name')->clearDecorators();
//	$form->getElement('name')->addDecorator('viewHelper');
//	$form->getElement('name')->addDecorator('Errors');
//	
//	$form->getElement('email')->clearDecorators();
//	$form->getElement('email')->addDecorator('viewHelper');
//	$form->getElement('email')->addDecorator('Errors');
//	
//	$form->getElement('phone')->clearDecorators();
//	$form->getElement('phone')->addDecorator('viewHelper');
//	$form->getElement('phone')->addDecorator('Errors');
//	
//	$form->getElement('message')->clearDecorators();
//	$form->getElement('message')->addDecorator('viewHelper');
//	$form->getElement('message')->addDecorator('Errors');
//	
//        $captchaDir = Zend_Controller_Front::getInstance()->getParam('bootstrap')->getOption('captchaDir');
//        $form->addElement('captcha', 'captcha',
//            array(
//            'label' => 'Rewrite the chars', 
//            'captcha' => array(
//                'captcha' => 'Leads',  
//                'wordLen' => 5,  
//                'timeout' => 300,
//                'font' => APPLICATION_PATH . '/../data/arial.ttf',  
//                'imgDir' => $captchaDir,  
//                'imgUrl' => $this->view->serverUrl() . '/captcha/',  
//            )
//        ));
//        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                   if(!strlen($contactEmail)){
                        $this->_helper->alertor->gotoUrl($this->view->url(array('success' => 'fail'), 'domain-contact'));
                    }
                    $values = $_POST;
                    $serviceService->sendMail($values,$contactEmail,$mailerEmail);
                    
                    
                    $this->_helper->getHelper('FlashMessenger')->setNamespace('success')->addMessage($this->view->translate('Thank you for your message. We will contact you soon.'));
                    $this->_helper->alertor->gotoUrl($this->view->url(array('success' => 'fail'), 'domain-contact'));
                    
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
//          
//
//        $this->view->assign('form', $form);
        $this->_helper->actionStack('layout', 'index', 'default');
    }
    
    public function sliderAction() {
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $rankingService = $this->_service->getService('Agent_Service_Ranking');
        
        $bestAgent = $rankingService->getBestAgentOfLastMonth();
        
//        $sliderService = $this->_service->getService('Slider_Service_Slider');
//        $slideLayerService = $this->_service->getService('Slider_Service_SlideLayer');
//        $mainSliderSlides = $sliderService->getAllForSlider("main");
//        $mainSlides = array();
//        foreach($mainSliderSlides[0]['Slides'] as $slide):
//            $layers = $slideLayerService->getLayersForSlide($slide['id']);
//            $slide['Layers'] = $layers;
//            $mainSlides[] = $slide;
//        endforeach;
//        $this->view->assign('mainSlides',$mainSlides);
        
        $this->view->assign('bestAgent',$bestAgent);
        $this->_helper->viewRenderer->setResponseSegment('slider');
	
	
     
    }
    
    public function menuAction(){
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $menuService = $this->_service->getService('Menu_Service_Menu');
        
       
        if(!$menu = $menuService->getMenu(1)) {
            throw new Zend_Controller_Action_Exception('Menu not found');
        }
        
        $treeRoot = $menuService->getMenuItemTree($menu, $this->view->language);
        $tree = $treeRoot[0]->getNode()->getChildren();
            
        $activeLanguages = $i18nService->getLanguageList();
        
        $this->view->assign('activeLanguages', $activeLanguages);
        
        $this->view->assign('menu', $menu);
        $this->view->assign('tree', $tree);
        
        $this->_helper->viewRenderer->setNoRender();
    }
    
     public function aboutUsAction() {
       
        $pageService = $this->_service->getService('Page_Service_Page');
        $metatagService = $this->_service->getService('Default_Service_Metatag');

        if(!$page = $pageService->getI18nPage('about-us', 'type', $this->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Page not found');
        }
        
        if(!$dlaMediow = $pageService->getI18nPage('dla-mediow', 'type', $this->language, Doctrine_Core::HYDRATE_RECORD)) {
            throw new Zend_Controller_Action_Exception('Page not found');
        }
        
        $boardService = $this->_service->getService('League_Service_Board');
        $boards = $boardService->getAllBoards(Doctrine_Core::HYDRATE_ARRAY);
        $this->view->assign('boards',$boards);
        
        $metatagService->setViewMetatags($page['metatag_id'], $this->view);
        
        $this->_helper->actionStack('layout', 'index', 'default');
        $this->view->assign('page', $page);
        $this->view->assign('dlaMediow', $dlaMediow);
        $this->view->assign('hideSlider', true);
    }
}
