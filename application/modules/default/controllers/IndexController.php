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

    public function leftSidebarAction()
    {
       
        $modelNews = new Unverified_Model_News();
        
        
        
        $news = $modelNews->getAllNewsNoPagination(6);
       
        $this->view->assign('news',$news);
        
        $this->_helper->viewRenderer->setResponseSegment('leftSidebar');
    }

    public function sidebarAction()
    {
        $resultService = $this->_service->getService('League_Service_Match');
          
        $results = $resultService->getLastResults();
        $this->view->assign('lastResults',$results);
        $this->_helper->viewRenderer->setResponseSegment('sidebar');
    }

    public function footerAction()
    {
        $this->_helper->viewRenderer->setResponseSegment('footer');
    }

    public function showNewsAction()
    {
         $modelNews = new Unverified_Model_News();
         $modelPhoto = new Unverified_Model_Photo();
        
        
//         $allNews = $modelNews->getAllNewsNoPagination(1500);
//    
//         foreach($allNews as $n):
//        //     echo "ok";
//             $slug = Unverified_Model_News::createUniqueTableSlug('aktualnosci', $n['tytul']);
//             $modelNews->addSlug($n['id_news'],$slug);
//         endforeach;
//         exit;
        if(!$news = $modelNews->getNews($this->getRequest()->getParam('slug'))){
            throw new Zend_Exception('News not found');
        }
        $this->view->assign('news',$news);
        $this->view->modelPhoto = $modelPhoto;
        $this->_helper->actionStack('layout');
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
    
     public function moveDatabaseAction()
    {
        /* moving database from old allagents to new */
        ini_set('max_execution_time',1500);
        ini_set('memory_limit', '1024M');
        $handle = mysql_connect('192.168.200.18','root','#12let123!#','allagent_db1') or die(mysql_error());
        mysql_select_db('allagent_db1');
        mysql_set_charset('UTF8');
        
        // agents start
        
        
//        $agentService = $this->_service->getService('Agent_Service_Agent');
//        $agentContactService = $this->_service->getService('Agent_Service_Contact');
//        $agentMemberService = $this->_service->getService('Agent_Service_Member');
//        
//        $agentQuery = "select * from agents where aid";
//        $agentResult = mysql_query($agentQuery);
//        if (!$agentResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($agentRow = mysql_fetch_array($agentResult,MYSQLI_ASSOC)){
//            try{
//                $data = $agentRow;
//                $data['id'] = $data['aid'];
//                $data['agent_id'] = $data['aid'];
//
//                if($data['transparency']=="-1"){
//                    $data['transparency'] = 0;
//                }
//
//                $agent = $agentService->saveAgentFromArray($data);
//                $agent->set('id',$agentRow['aid']);
//                $agent->save();
//
//                $agentMemberService->saveMemberFromArray($data);
//
//                for($i=1;$i<=3;$i++):
//                    if($i==1)
//                        $counter = "";
//                    else
//                        $counter = $i;
//                    if(strlen($agentRow['contact_firstname'.$counter])||strlen($agentRow['contact_lastname'.$counter])){
//                        $data['firstname'] = $agentRow['contact_firstname'.$counter];
//                        $data['lastname'] = $agentRow['contact_lastname'.$counter];
//                        $data['tel'] = $agentRow['contact_tel'.$counter];
//                        $data['mob'] = $agentRow['contact_mob'.$counter];
//                        $data['email'] = $agentRow['contact_email'.$counter];
//                        $data['notes'] = $agentRow['contact_notes'.$counter];
//                        $data['agent_id'] = $agentRow['aid'];
//                        $agentContactService->saveContactFromArray($data);
//                    }
//                endfor;
//            }
//            catch(Exception $e){
//                var_dump($agentRow);
//                var_dump($e->getMessage());exit;
//            }
//            
//        }
//        
//        $agentAwardService = $this->_service->getService('Agent_Service_Award');
//        
//        $agentAwardQuery = "select * from awards_agents";
//        $agentAwardResult = mysql_query($agentAwardQuery);
//        if (!$agentAwardResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($agentAwardRow = mysql_fetch_array($agentAwardResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($agentAwardRow);
//            try{
//                $data = $agentAwardRow;
//                $data['id'] = $data['aid'];
//                $data['agent_id'] = $data['aid'];
//                $data['chain_size'] = $data['chain_size'];
//
//
//                $agentAward = $agentAwardService->saveAwardFromArray($data);
//
//            }
//            catch(Exception $e){
//                var_dump($agentAward);
//                var_dump($e->getMessage());exit;
//            }
//            
//        }
//        
//        $rankingService = $this->_service->getService('Agent_Service_Ranking');
//        
//        $agentRankingMonthlyQuery = "select * from ukrankings";
//        $agentRankingMonthlyResult = mysql_query($agentRankingMonthlyQuery);
//        if (!$agentRankingMonthlyResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($agentRankingMonthlyRow = mysql_fetch_array($agentRankingMonthlyResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($agentRankingMonthlyRow);
//            try{
//                $data = $agentRankingMonthlyRow;
//                $data['id'] = $data['aid'];
//                $data['agent_id'] = $data['aid'];
//                $data['chain_size'] = $data['chain_size'];
//
//
//                $agentClaim = $rankingService->saveMonthlyRankingFromArray($data);
//
//            }
//            catch(Exception $e){
//                var_dump($agentRankingMonthlyRow);
//                var_dump($e->getMessage());exit;
//            }
//            
//        }
//        
//        $agentRankingWeeklyQuery = "select * from ukrankings_week";
//        $agentRankingWeeklyResult = mysql_query($agentRankingWeeklyQuery);
//        if (!$agentRankingWeeklyResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($agentRankingWeeklyRow = mysql_fetch_array($agentRankingWeeklyResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($agentRankingWeeklyRow);
//            try{
//                $data = $agentRankingWeeklyRow;
//                
//                for($i=1;$i<=52;$i++):
//                    $goodData = array();
//                    $goodData['agent_id'] = $data['aid'];
//                    $goodData['year'] = $data['year'];
//                    $goodData['week'] = $i;
//                    $goodData['position'] = $data['week'.$i];
//                 $rankingService->saveWeeklyRankingFromArray($goodData);
//
//                endfor;
//
//            }
//            catch(Exception $e){
//                var_dump($agentRankingWeeklyRow);
//                var_dump($e->getMessage());exit;
//            }
//            
//        }
//        
//        $notesService = $this->_service->getService('Agent_Service_Notes');
//        
//        $agentNotesQuery = "select * from notes";
//        $agentNotesResult = mysql_query($agentNotesQuery);
//        if (!$agentNotesResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($agentNotesRow = mysql_fetch_array($agentNotesResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($agentNotesRow);
//            try{
//                $data = $agentNotesRow;
//                $data['agent_id'] = $data['aid'];
//                $data['created_at'] = $data['notedate']." 00:00:00";
//                $data['updated_at'] = $data['notedate']." 00:00:00";
//                if(strlen($data['callback'])){
//                    $data['callback'] = date('Y-m-d H:i:s',$data['callback']);
//                }
//                $data['updated_at'] = $data['notedate']." 00:00:00";
//                
//                 $notesService->saveNotesFromArray($data);
//
//
//            }
//            catch(Exception $e){
//                var_dump($agentNotesRow);
//                var_dump($e->getMessage());exit;
//            }
//            
//        }
//        
//        $postcodeService = $this->_service->getService('Agent_Service_Postcode');
//        
//        $agentPostcodeQuery = "select * from postcodes_agents";
//        $agentPostcodeResult = mysql_query($agentPostcodeQuery);
//        if (!$agentPostcodeResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($agentPostcodeRow = mysql_fetch_array($agentPostcodeResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($agentPostcodeRow);
//            try{
//                $data = $agentPostcodeRow;
//               
//                 $postcodeService->savePostcodeFromArray($data);
//
//
//            }
//            catch(Exception $e){
//                var_dump($agentPostcodeRow);
//                var_dump($e->getMessage());exit;
//            }
//            
//        }
//        
//        $enquiryService = $this->_service->getService('Agent_Service_Enquiry');
//        
//        $agentEnquiryQuery = "select * from contact_trans_agents";
//        $agentEnquiryResult = mysql_query($agentEnquiryQuery);
//        if (!$agentEnquiryResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($agentEnquiryRow = mysql_fetch_array($agentEnquiryResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($agentEnquiryRow);
//            try{
//                $data = $agentEnquiryRow;
//               $data['tel'] = $data['phone'];
//               $data['created_at'] = $data['enqdate'];
//                 $enquiryService->saveEnquiryFromArray($data);
//
//
//            }
//            catch(Exception $e){
//                var_dump($agentEnquiryRow);
//                var_dump($e->getMessage());exit;
//            }
//            
//        }
        
        
        // agent finish
        
        // branch start
        
//        $branchService = $this->_service->getService('Branch_Service_Branch');
//        $branchQuery = "select * from branches";
//        $branchResult = mysql_query($branchQuery);
//        if (!$branchResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($branchRow = mysql_fetch_array($branchResult,MYSQLI_ASSOC)){
////            Zend_Debug::dump($branchRow);
//            try{
//                $data = $branchRow;
//                $data['id'] = $data['bid'];
//                $data['branch_id'] = $data['bid'];
//                $data['agent_id'] = $data['agent'];
//                $data['premium_support'] = $data['premium_support_branch'];
//
//                if($data['transparency']=="-1"){
//                    $data['transparecy'] = 0;
//                }
//                
//                $branch = $branchService->saveBranchFromArray($data);
//                $branch->set('id',$branchRow['bid']);
//                $branch->save();
//                
//                }
//            catch(Exception $e){
//                var_dump($branchRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//        $branchAreaCoveredService = $this->_service->getService('Branch_Service_AreaCovered');
//        $branchAreaCoveredQuery = "select * from branch_areas_covered";
//        $branchAreaCoveredResult = mysql_query($branchAreaCoveredQuery);
//        if (!$branchAreaCoveredResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($branchAreaCoveredRow = mysql_fetch_array($branchAreaCoveredResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($branchAreaCoveredRow);
//            try{
//                
//                for($i=1;$i<=10;$i++):
//                    if(strlen($branchAreaCoveredRow['postcode'.$i])){
//                        $data = array();
//                        $data['branch_id'] = $branchAreaCoveredRow['bid'];
//                        $data['area'] = $branchAreaCoveredRow['postcode'.$i];
//                        $branchAreaCoveredService->saveAreaCoveredFromArray($data);
//                    }
//                    if(strlen($branchAreaCoveredRow['area'.$i])){
//                        $data = array();
//                        $data['branch_id'] = $branchAreaCoveredRow['bid'];
//                        $data['area'] = $branchAreaCoveredRow['postcode'.$i];
//                        $branchAreaCoveredService->saveAreaCoveredFromArray($data);
//                    }
//                endfor;
//                
//                }
//            catch(Exception $e){
//                var_dump($branchAreaCoveredRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//        $branchComplaintProcedureService = $this->_service->getService('Branch_Service_ComplaintProcedure');
//        $branchComplaintProcedureQuery = "select * from complaints_procedure";
//        $branchComplaintProcedureResult = mysql_query($branchComplaintProcedureQuery);
//        if (!$branchComplaintProcedureResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($branchComplaintProcedureRow = mysql_fetch_array($branchComplaintProcedureResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($branchComplaintProcedureRow);
//            try{
//                
//                        $data = $branchComplaintProcedureRow;
//                        $data['branch_id'] = $branchComplaintProcedureRow['bid'];
//                        $data['created_at'] = date('Y-m-d H:i:s',$branchComplaintProcedureRow['createtime']);
//                        $data['updated_at'] = date('Y-m-d H:i:s',$branchComplaintProcedureRow['updatetime']);
//                        $branchComplaintProcedureService->saveComplaintProcedureFromArray($data);
//                    
//                
//                }
//            catch(Exception $e){
//                var_dump($branchComplaintProcedureRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//        $branchCustomerService = $this->_service->getService('Branch_Service_Customer');
//        $branchCustomerQuery = "select * from branch_customers";
//        $branchCustomerResult = mysql_query($branchCustomerQuery);
//        if (!$branchCustomerResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($branchCustomerRow = mysql_fetch_array($branchCustomerResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($branchCustomerRow);
//            try{
//                
//                        $data = $branchCustomerRow;
//                        $data['branch_id'] = $branchCustomerRow['bid'];
//                        $data['tel'] = $branchCustomerRow['telephone'];
//                        $data['capacity'] = (int)$branchCustomerRow['capacity'];
//                        if($branchCustomerRow['reviewed']=="0000-00-00 00:00:00"){
//                            unset($data['reviewed']);
//                        }
//                        $branchCustomerService->saveCustomerFromArray($data);
//                    
//                
//                }
//            catch(Exception $e){
//                var_dump($branchCustomerRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//        $branchFeeService = $this->_service->getService('Branch_Service_Fee');
//        $branchFeeQuery = "select * from agent_fees";
//        $branchFeeResult = mysql_query($branchFeeQuery);
//        if (!$branchFeeResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($branchFeeRow = mysql_fetch_array($branchFeeResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($branchFeeRow);
//            try{
//                
//                        $data = $branchFeeRow;
//                        $data['branch_id'] = $branchFeeRow['bid'];
//                        $data['created_at'] = date('Y-m-d H:i:s',$branchFeeRow['createtime']);
//                        $data['updated_at'] = date('Y-m-d H:i:s',$branchFeeRow['updatetime']);
//                        $branchFeeService->saveFeesFromArray($data);
//                    
//                
//                }
//            catch(Exception $e){
//                var_dump($branchFeeRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//        $branchMemberService = $this->_service->getService('Branch_Service_Member');
//        $branchMemberQuery = "select * from branch_checkboxes";
//        $branchMemberResult = mysql_query($branchMemberQuery);
//        if (!$branchMemberResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($branchMemberRow = mysql_fetch_array($branchMemberResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($branchMemberRow);
//            try{
//                
//                        $data = $branchMemberRow;
//                        $data['branch_id'] = $branchMemberRow['branchid'];
//                        $branchMemberService->saveMemberFromArray($data);
//                    
//                
//                }
//            catch(Exception $e){
//                var_dump($branchMemberRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//        $branchClaimService = $this->_service->getService('Branch_Service_Claim');
//        $branchClaimQuery = "select * from awards_branches";
//        $branchClaimResult = mysql_query($branchClaimQuery);
//        if (!$branchClaimResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($branchClaimRow = mysql_fetch_array($branchClaimResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($branchClaimRow);
//            try{
//                
//                        $data = $branchClaimRow;
//                        $data['branch_id'] = $branchClaimRow['bid'];
//                        $data['tel'] = $branchClaimRow['telephone'];
//                        if($branchClaimRow['reviewed']=="0000-00-00 00:00:00"){
//                            unset($data['reviewed']);
//                        }
//                        $branchClaimService->saveClaimFromArray($data);
//                    
//                
//                }
//            catch(Exception $e){
//                var_dump($branchClaimRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//        $branchEnquiryService = $this->_service->getService('Branch_Service_Enquiry');
//        $branchEnquiryQuery = "select * from contact_branch";
//        $branchEnquiryResult = mysql_query($branchEnquiryQuery);
//        if (!$branchEnquiryResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($branchEnquiryRow = mysql_fetch_array($branchEnquiryResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($branchEnquiryRow);
//            try{
//                
//                        $data = $branchEnquiryRow;
//                        $data['branch_id'] = $branchEnquiryRow['bid'];
//                        $data['tel'] = $branchEnquiryRow['phone'];
//                        $data['created_at'] = date('Y-m-d H:i:s',$branchEnquiryRow['date']);
//                        
//                        $branchEnquiryService->saveEnquiryFromArray($data);
//                    
//                
//                }
//            catch(Exception $e){
//                var_dump($branchEnquiryRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//        $branchRightmoveService = $this->_service->getService('Branch_Service_Rightmove');
//        $branchRightmoveQuery = "select * from rightmove_branch_ids";
//        $branchRightmoveResult = mysql_query($branchRightmoveQuery);
//        if (!$branchRightmoveResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($branchRightmoveRow = mysql_fetch_array($branchRightmoveResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($branchRightmoveRow);
//            try{
//                
//                        $data = $branchRightmoveRow;
//                        $data['branch_id'] = $branchRightmoveRow['bid'];
////                        $data['tel'] = $branchRightmoveRow['phone'];
////                        $data['created_at'] = date('Y-m-d H:i:s',$branchRightmoveRow['date']);
//                        
//                        $branchRightmoveService->saveRightmoveFromArray($data);
//                    
//                
//                }
//            catch(Exception $e){
//                var_dump($branchRightmoveRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//        $branchUpdateService = $this->_service->getService('Branch_Service_Update');
//        $branchUpdateQuery = "select * from update_branch_info";
//        $branchUpdateResult = mysql_query($branchUpdateQuery);
//        if (!$branchUpdateResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($branchUpdateRow = mysql_fetch_array($branchUpdateResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($branchUpdateRow);
//            try{
//                
//                        $data = $branchUpdateRow;
//                        $data['branch_id'] = $branchUpdateRow['bid'];
//                        $data['contact_name'] = $branchUpdateRow['whofirstname']." ".$branchUpdateRow['wholastname'];
//                        $data['contact_email'] = $branchUpdateRow['whoemail'];
//                        $data['contact_tel'] = $branchUpdateRow['whotel'];
//                        $data['contact_job'] = $branchUpdateRow['whojob'];
//                        $data['tel'] = $branchUpdateRow['telephone'];
//                        $data['created_at'] = date('Y-m-d H:i:s',$branchUpdateRow['date']);
//                        
//                        $update = $branchUpdateService->saveUpdateFromArray($data);
//                        for($i=1;$i<=10;$i++):
//                            $areaData = array();
//                            if(strlen($data['postcode'.$i])){
//                                $areaData['area'] = trim($data['postcode'.$i]);
//                                $areaData['update_id'] = $update['id'];
//                                $updateAreasCovered = $branchUpdateService->saveUpdateAreasCoveredFromArray($areaData);
//                            }
//                            if(strlen($data['area'.$i])){
//                                $areaData['area'] = trim($data['area'.$i]);
//                                $areaData['update_id'] = $update['id'];
//                                $updateAreasCovered = $branchUpdateService->saveUpdateAreasCoveredFromArray($areaData);
//                            }
//                        endfor;
//                        $memberData = array();
//                        $memberData['update_id'] = $update['id'];
//                        foreach($data as $key => $value):
//                            if($value=="off"||$value=="on"){
//                                if($value=="off"){
//                                    $memberData[$key] = 0;
//                                }
//                                else{
//                                    $memberData[$key] = 1;
//                                }
//                            }
//                        endforeach;
//                        $updateMember = $branchUpdateService->saveUpdateMemberFromArray($memberData);
//                    
//                
//                }
//            catch(Exception $e){
//                var_dump($branchUpdateRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
        // branch finish
        
        // job start 
        
//        $jobService = $this->_service->getService('Job_Service_Job');
//        $jobQuery = "select * from jobs";
//        $jobResult = mysql_query($jobQuery);
//        if (!$jobResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($jobRow = mysql_fetch_array($jobResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($jobRow);
//            try{
//                
//                        $data = $jobRow;
//                        $data['branch_id'] = $jobRow['bid'];
//                        $data['agent_id'] = $jobRow['aid'];
//                        $data['created_at'] = $jobRow['date_added'];
//                        $job = $jobService->saveJobFromArray($data);
//                        $job->set('id',$jobRow['jid']);
//                        $job->save();
//                    
//                
//                }
//            catch(Exception $e){
//                var_dump($jobRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $jobApplicationService = $this->_service->getService('Job_Service_Application');
//        $jobApplicationQuery = "select * from job_applications";
//        $jobApplicationResult = mysql_query($jobApplicationQuery);
//        if (!$jobApplicationResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($jobApplicationRow = mysql_fetch_array($jobApplicationResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($jobApplicationRow);
//            try{
//                
//                        $data = $jobApplicationRow;
//                        $data['branch_id'] = $jobApplicationRow['bid'];
//                        $data['job_id'] = $jobApplicationRow['jid'];
//                        $data['agent_id'] = $jobApplicationRow['aid'];
//                        $data['created_at'] = $jobApplicationRow['date_applied'];
//                        $data['tel'] = $jobApplicationRow['telephone'];
//                        $data['mob'] = $jobApplicationRow['mobile'];
//                        $jobApplication = $jobApplicationService->saveApplicationFromArray($data);
//                    
//                
//                }
//            catch(Exception $e){
//                var_dump($jobApplicationRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $jobUnverifiedService = $this->_service->getService('Job_Service_Unverified');
//        $jobUnverifiedQuery = "select * from jobs_unverified";
//        $jobUnverifiedResult = mysql_query($jobUnverifiedQuery);
//        if (!$jobUnverifiedResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($jobUnverifiedRow = mysql_fetch_array($jobUnverifiedResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($jobUnverifiedRow);
//            try{
//                
//                        $data = $jobUnverifiedRow;
//                        $data['agent_id'] = $jobUnverifiedRow['aid'];
//                        $data['created_at'] = $jobUnverifiedRow['date_added'];
//                        $jobUnverified = $jobUnverifiedService->saveUnverifiedFromArray($data);
//                    
//                
//                }
//            catch(Exception $e){
//                var_dump($jobUnverifiedRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
        // job finish
        
        
        /*
         * 
         * LOOOP THIS BECAUSE IT STACKS !!
         * 
         * 
         */
        
        
        // staff start
        
//         $staffService = $this->_service->getService('Staff_Service_Staff');
//        $staffQuery = "select s.*,p.telephone,p.mob,p.picture,p.email,p.sex,p.dob,p.birthplace,p.sport,p.team,p.twitter,p.facebook,p.linkedin from staff s inner join profile p on p.id = s.profileid where profileid > 1000072688 order by p.id limit 5000";
//        $staffResult = mysql_query($staffQuery);
//        if (!$staffResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($staffRow = mysql_fetch_array($staffResult,MYSQLI_ASSOC)){
////            Zend_Debug::dump($staffRow);
//            try{
//                
//                $isStaff = $staffService->getStaff($staffRow['profileid'],'id');
//                if($isStaff && !empty($isStaff)){
//                    if($isStaff['firstname']==$staffRow['firstname']&&$isStaff['lastname']==$staffRow['lastname']){
//                        $isStaff->link('Branches',$staffRow['branch']);
//                        $isStaff->save();
//                        continue;
//                    }
//                    else{
//                        
//                        echo "error";
//                        continue;
//                    }
//                }
//                $data = $staffRow;
//                $data['agent_id'] = $staffRow['agent'];
//                $data['branch_id'] = $staffRow['branch'];
//                $data['main_branch_id'] = $staffRow['branch'];
//                $data['tel'] = $staffRow['telephone'];
//                $data['created_at'] = $staffRow['date_added'];
//                $data['link'] = MF_Text::createSlug($staffRow['firstname']." ".$staffRow['lastname']);
//                if(strlen($staffRow['dob'])){
//                    if($staffRow['dob']=="0000-00-00"){
//                        $data['dob'] = null;
//                    }
//                    else{
//                        $noYear = substr($staffRow['dob'],5,5);
//                        if($noYear=="00-00"){
//                            $data['dob'] = substr($staffRow['dob'],0,4)."-01-01";
//                        }
//                        else{
//                            $data['dob'] = $staffRow['dob'];
//                        }
//                    }
//                }
//                $staff = $staffService->saveStaffFromArray($data);
//                $staff->set('id',$staffRow['profileid']);
//                $staff->save();
//                $staff->link('Branches',$staffRow['branch']);
//                $staff->save();
//                
//                }
//            catch(Exception $e){
//                var_dump($data['dob']);
//                var_dump($staffRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
        /*
         * STOP LOOOP
         * 
         * 
         */
        
//        $staffAreaCoveredService = $this->_service->getService('Staff_Service_AreaCovered');
//        $staffAreaCoveredQuery = "select sac.*,s.profileid from staff_areas_covered sac inner join staff s on sac.sid = s.sid";
//        $staffAreaCoveredResult = mysql_query($staffAreaCoveredQuery);
//        if (!$staffAreaCoveredResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($staffAreaCoveredRow = mysql_fetch_array($staffAreaCoveredResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($staffAreaCoveredRow);
//            try{
//                
//                for($i=1;$i<=10;$i++):
//                    if(strlen(trim($staffAreaCoveredRow['postcode'.$i]))){
//                        $data = array();
//                        $data['staff_id'] = $staffAreaCoveredRow['profileid'];
//                        $data['area'] = $staffAreaCoveredRow['postcode'.$i];
//                        $staffAreaCoveredService->saveAreaCoveredFromArray($data);
//                    }
//                    if(strlen(trim($staffAreaCoveredRow['area'.$i]))){
//                        $data = array();
//                        $data['staff_id'] = $staffAreaCoveredRow['profileid'];
//                        $data['area'] = $staffAreaCoveredRow['area'.$i];
//                        $staffAreaCoveredService->saveAreaCoveredFromArray($data);
//                    }
//                endfor;
//                
//                }
//            catch(Exception $e){
//                var_dump($staffAreaCoveredRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $staffClaimService = $this->_service->getService('Staff_Service_Claim');
//        $staffClaimQuery = "select * from awards_staff";
//        $staffClaimResult = mysql_query($staffClaimQuery);
//        if (!$staffClaimResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($staffClaimRow = mysql_fetch_array($staffClaimResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($staffClaimRow);
//            try{
//                
//                        $data = $staffClaimRow;
//                        $data['staff_id'] = $staffClaimRow['profileid'];
//                        $data['agent_id'] = $staffClaimRow['aid'];
//                        $staffClaimService->saveClaimFromArray($data);
//                    
//                
//                }
//            catch(Exception $e){
//                var_dump($staffClaimRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//        
       
//        $staffClaimService = $this->_service->getService('Staff_Service_Claim');
//        $staffClaimQuery = "select * from profile_claims";
//        $staffClaimResult = mysql_query($staffClaimQuery);
//        if (!$staffClaimResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($staffClaimRow = mysql_fetch_array($staffClaimResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($staffClaimRow);
//            try{
//                
//                        $data = $staffClaimRow;
//                        if(strlen($staffClaimRow['dob'])){
//                            if($staffClaimRow['dob']=="0000-00-00"){
//                                $data['dob'] = null;
//                            }
//                            else{
//                                $noYear = substr($staffClaimRow['dob'],5,5);
//                                if($noYear=="00-00"){
//                                    $data['dob'] = substr($staffClaimRow['dob'],0,4)."-01-01";
//                                }
//                                else{
//                                    $data['dob'] = $staffClaimRow['dob'];
//                                }
//                            }
//                        }
//                        $data['staff_id'] = $staffClaimRow['profileid'];
//                        $data['tel'] = $staffClaimRow['telephone'];
//                        $staffClaimService->saveClaimFromArray($data);
//                    
//                
//                }
//            catch(Exception $e){
//                var_dump($staffClaimRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $staffUpdateService = $this->_service->getService('Staff_Service_Update');
//        $staffUpdateRequestQuery = "select * from staff_branch_update_request";
//        $staffUpdateRequestResult = mysql_query($staffUpdateRequestQuery);
//        if (!$staffUpdateRequestResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        while($staffUpdateResultRow = mysql_fetch_array($staffUpdateRequestResult,MYSQLI_ASSOC)){
//            try{
//                
//                        $data = $staffUpdateResultRow;
//                        $data['branch_id'] = $staffUpdateResultRow['bid'];
//                        
//                        $updateRequest = $staffUpdateService->saveUpdateRequestFromArray($data);
//                        $updateRequest->set('id',$staffUpdateResultRow['id']);
//                        $updateRequest->save();
//                        
//                        $staffUpdateQuery = "select * from staff_branch_update where requestid = ".$updateRequest->get('id');
//                        $staffUpdateResult = mysql_query($staffUpdateQuery);
//                        if (!$staffUpdateResult) {
//                            $message  = 'Invalid query: ' . mysql_error() . "\n";
//                            die($message);
//                        }
//                        
//                        while($staffUpdateRow = mysql_fetch_array($staffUpdateResult,MYSQLI_ASSOC)){
//                            Zend_Debug::dump($staffUpdateRow);
//                            try{
//
//                                        $data = $staffUpdateRow;
//                                        $data['branch_id'] = $staffUpdateRow['bid'];
//                                        $data['staff_id'] = $staffUpdateRow['profileid'];
//                                        $data['request_id'] = $staffUpdateRow['requestid'];
//                                        $data['tel'] = $staffUpdateRow['telephone'];
//                                        if(strlen($staffUpdateRow['dob'])){
//                                            if($staffUpdateRow['dob']=="0000-00-00"){
//                                                $data['dob'] = null;
//                                            }
//                                            else{
//                                                $noYear = substr($staffUpdateRow['dob'],5,5);
//                                                if($noYear=="00-00"){
//                                                    $data['dob'] = substr($staffUpdateRow['dob'],0,4)."-01-01";
//                                                }
//                                                else{
//                                                    $data['dob'] = $staffUpdateRow['dob'];
//                                                }
//                                            }
//                                        }
//                                        if($staffUpdateRow['deleted']){
//                                            $data['deleted_at'] = date('Y-m-d H:i:s');
//                                        }
//                                        $update = $staffUpdateService->saveUpdateFromArray($data);
//                                        for($i=1;$i<=10;$i++):
//                                            if(strlen(trim($data['postcode'.$i]))){
//                                                $pcData = array();
//                                                $pcData['area'] = $data['postcode'.$i];
//                                                $pcData['update_id'] = $update->get('id');
//                                                $staffUpdateService->saveUpdateAreaFromArray($pcData);
//                                            }
//                                        endfor;
//                                       
//                                }
//                            catch(Exception $e){
//                                var_dump($staffUpdateResultRow);
//                                var_dump($e->getMessage());exit;
//                            }
//                        }
//                        
//                        $staffUpdateMergeQuery = "select * from staff_branch_update_merge where requestid = ".$updateRequest->get('id');
//                        $staffUpdateMergeResult = mysql_query($staffUpdateMergeQuery);
//                        if (!$staffUpdateMergeResult) {
//                            $message  = 'Invalid query: ' . mysql_error() . "\n";
//                            die($message);
//                        }
//                        
//                        while($staffUpdateMergeRow = mysql_fetch_array($staffUpdateMergeResult,MYSQLI_ASSOC)){
//                            Zend_Debug::dump($staffUpdateMergeRow);
//                            try{
//
//                                        $data = $staffUpdateMergeRow;
//                                        $data['request_id'] = $staffUpdateMergeRow['requestid'];
//                                        $data['merge_from_staff_id'] = $staffUpdateMergeRow['merge_from_profileid'];
//                                        $data['merge_to_staff_id'] = $staffUpdateMergeRow['merge_to_profileid'];
//                                        
//                                        $updateRequest = $staffUpdateService->saveUpdateMergeFromArray($data);
//                                       
//                                }
//                            catch(Exception $e){
//                                var_dump($staffUpdateMergeResultRow);
//                                var_dump($e->getMessage());exit;
//                            }
//                        }
//                        
//                        $staffUpdateDeleteQuery = "select * from staff_branch_update_delete where requestid = ".$updateRequest->get('id');
//                        $staffUpdateDeleteResult = mysql_query($staffUpdateDeleteQuery);
//                        if (!$staffUpdateDeleteResult) {
//                            $message  = 'Invalid query: ' . mysql_error() . "\n";
//                            die($message);
//                        }
//                        
//                        while($staffUpdateDeleteRow = mysql_fetch_array($staffUpdateDeleteResult,MYSQLI_ASSOC)){
//                            Zend_Debug::dump($staffUpdateDeleteRow);
//                            try{
//
//                                        $data = $staffUpdateDeleteRow;
//                                        $data['request_id'] = $staffUpdateDeleteRow['requestid'];
//                                        $data['reason'] = $staffUpdateDeleteRow['reason'];
//                                        $data['staff_id'] = $staffUpdateDeleteRow['profileid'];
//                                        
//                                        $updateRequest = $staffUpdateService->saveUpdateDeleteFromArray($data);
//                                       
//                                }
//                            catch(Exception $e){
//                                var_dump($staffUpdateDeleteResultRow);
//                                var_dump($e->getMessage());exit;
//                            }
//                        }
//                
//                }
//            catch(Exception $e){
//                var_dump($staffUpdateDeleteResultRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
        // staff finish
        
        // supplier start
        
        
//        $supplierService = $this->_service->getService('Supplier_Service_Supplier');
//        $contactService = $this->_service->getService('Supplier_Service_Contact');
//        $supplierQuery = "select * from supplier";
//        $supplierResult = mysql_query($supplierQuery);
//        if (!$supplierResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($supplierRow = mysql_fetch_array($supplierResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($supplierRow);
//            try{
//                
//                        $data = array_change_key_case($supplierRow);
//                        
//                        $data['tel'] = $data['telephone'];
//                        $supplier = $supplierService->saveSupplierFromArray($data);
//                        $supplier->set('id',$data['id']);
//                        $supplier->save();
//                        for($i=1;$i<=2;$i++):
//                            if(strlen($data['contact'.$i."_first_name"])||$data['contact'.$i."_last_name"]){
//                            $contactData = array();
//                        $contactData['firstname'] = $data['contact'.$i."_first_name"];
//                        $contactData['lastname'] = $data['contact'.$i."_last_name"];
//                        $contactData['position'] = $data['contact'.$i."_position"];
//                        $contactData['email'] = $data['contact'.$i."_email"];
//                        $contactData['tel'] = $data['contact'.$i."_telephone"];
//                        $contactData['supplier_id'] = $supplier->get('id');
//                            $contact = $contactService->saveContactFromArray($contactData);
//                            }
//                        endfor;
//                }
//            catch(Exception $e){
//                var_dump($supplierRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $supplierCategoryService = $this->_service->getService('Supplier_Service_Category');
//        $supplierCategoryQuery = "select * from suplcategory";
//        $supplierCategoryResult = mysql_query($supplierCategoryQuery);
//        if (!$supplierCategoryResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($supplierCategoryRow = mysql_fetch_array($supplierCategoryResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($supplierCategoryRow);
//            try{
//                
//                        $data = $supplierCategoryRow;
//                        
//                        $data['tel'] = $data['telephone'];
//                        $supplierCategory = $supplierCategoryService->saveCategoryFromArray($data);
//                        $supplierCategory->set('id',$data['id']);
//                        $supplierCategory->save();
//                        
//                        $supplierSupplierCategoryQuery = "select * from supplier_categories where category_id = ".$data['id'];
//                        $supplierSupplierCategoryResult = mysql_query($supplierSupplierCategoryQuery);
//                        while($supplierSupplierCategoryRow = mysql_fetch_array($supplierSupplierCategoryResult,MYSQLI_ASSOC)){
//                            $supplierCategory->link('Suppliers',$supplierSupplierCategoryRow['supplier_id']);
//                            $supplierCategory->save();
//                        }
//                        
//                }
//            catch(Exception $e){
//                var_dump($supplierCategoryRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $supplierReviewService = $this->_service->getService('Supplier_Service_Review');
//        $supplierReviewQuery = "select * from supplier_reviews";
//        $supplierReviewResult = mysql_query($supplierReviewQuery);
//        if (!$supplierReviewResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($supplierReviewRow = mysql_fetch_array($supplierReviewResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($supplierReviewRow);
//            try{
//                
//                        $data = $supplierReviewRow;
//                        
//                        $supplierReview = $supplierReviewService->saveReviewFromArray($data);
//                        $supplierReview->set('id',$data['id']);
//                        $supplierReview->save();
//                        
//                        
//                }
//            catch(Exception $e){
//                var_dump($supplierReviewRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $supplierCommentService = $this->_service->getService('Supplier_Service_Comment');
//        $supplierCommentQuery = "select * from supplier_review_comments";
//        $supplierCommentResult = mysql_query($supplierCommentQuery);
//        if (!$supplierCommentResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($supplierCommentRow = mysql_fetch_array($supplierCommentResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($supplierCommentRow);
//            try{
//                
//                        $data = $supplierCommentRow;
//                        $data['review_id'] = $data['review'];
//                        $supplierComment = $supplierCommentService->saveCommentFromArray($data);
//                        $supplierComment->set('id',$data['cid']);
//                        $supplierComment->save();
//                        
//                        
//                }
//            catch(Exception $e){
//                var_dump($supplierCommentRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
        // supplier finish
        
        // review start
        
//        $this->moveReviews();
        
        $this->moveReviewComments();
        
//        $reviewFilesQuery = "select * from review_files ";
//        $reviewFilesResult = mysql_query($reviewFilesQuery);
//        if (!$reviewFilesResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($reviewFilesRow = mysql_fetch_array($reviewFilesResult,MYSQLI_ASSOC)){
//            try{
//                if(strlen(trim($reviewFilesRow['src']))>0)
//                {
//            Zend_Debug::dump($reviewFilesRow);
//                        $data = $reviewFilesRow;
//                        
//                        if($data['cid']!=0){
//                            $data['comment_id'] = $data['cid'];
//                            $comment = $reviewCommentService->saveFilesFromArray($data);
//                        }
//                        elseif($data['rid']!=0){
//                            $data['review_id'] = $data['rid'];
//                            $comment = $reviewService->saveFilesFromArray($data);
//                        }
//                        
//                }
//                }
//            catch(Exception $e){
//                var_dump($reviewFilesRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $reviewRankingService = $this->_service->getService('Review_Service_Ranking');
//        $reviewRankingWeekQuery = "select * from reviews_temp";
//        $reviewRankingWeekResult = mysql_query($reviewRankingWeekQuery);
//        if (!$reviewRankingWeekResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($reviewRankingWeekRow = mysql_fetch_array($reviewRankingWeekResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($reviewRankingWeekRow);
//            try{
//                
//                        $data = $reviewRankingWeekRow;
//                        $data['review_id'] = $data['rid'];
//                        $reviewRankingService->saveRankingWeekFromArray($data);
//                }
//            catch(Exception $e){
//                var_dump($reviewRankingWeekRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $reviewTempService = $this->_service->getService('Review_Service_Temp');
//        $reviewTempQuery = "select * from reviews_temp";
//        $reviewTempResult = mysql_query($reviewTempQuery);
//        if (!$reviewTempResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($reviewTempRow = mysql_fetch_array($reviewTempResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($reviewTempRow);
//            try{
//                
//                        $data = $reviewTempRow;
//                        $data['agent_id'] = $data['agent'];
//                        $data['branch_id'] = (int)$data['branch'];
//                        if($data['reminder']>0){
//                            $data['reminder'] = date('Y-m-d H:i:s',$data['reminder']);
//                        }
//                        else{
//                            $data['reminder'] = null;
//                        }
//                        $reviewTempService->saveTempFromArray($data);
//                }
//            catch(Exception $e){
//                var_dump($reviewTempRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
        // review finish
        
//        $this->moveAdvertising();
        
//        $this->reslugAdSource();
        
//        $this->setAgentMember();
        
        // properties start
        
        $this->moveProperties();
        
//        $propertyImageService = $this->_service->getService('Property_Service_Image');
//        $propertyImageQuery = "select * from media_image";
//        $propertyImageResult = mysql_query($propertyImageQuery);
//        if (!$propertyImageResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($propertyImageRow = mysql_fetch_array($propertyImageResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($propertyImageRow);
//            try{
//                
//                        $data = $propertyImageRow;
//                        $data['property_id'] = $data['pid'];
//                        $data['image'] = $data['media_image'];
//                        $data['order'] = $data['media_order'];
//                        $propertyImageService->saveImageFromArray($data);
//                        
//                       
//                        
//                }
//            catch(Exception $e){
//                var_dump($propertyRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $propertyFloorPlanService = $this->_service->getService('Property_Service_FloorPlan');
//        $propertyFloorPlanQuery = "select * from media_floor_plan";
//        $propertyFloorPlanResult = mysql_query($propertyFloorPlanQuery);
//        if (!$propertyFloorPlanResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($propertyFloorPlanRow = mysql_fetch_array($propertyFloorPlanResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($propertyFloorPlanRow);
//            try{
//                
//                        $data = $propertyFloorPlanRow;
//                        $data['property_id'] = $data['pid'];
//                        $data['floor_plan'] = $data['media_floor_plan'];
//                        $data['order'] = $data['media_order'];
//                        $propertyFloorPlanService->saveFloorPlanFromArray($data);
//                        
//                       
//                        
//                }
//            catch(Exception $e){
//                var_dump($propertyFloorPlanRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $propertyLeadsService = $this->_service->getService('Property_Service_Lead');
//        $propertyLeadsQuery = "select * from email_leads";
//        $propertyLeadsResult = mysql_query($propertyLeadsQuery);
//        if (!$propertyLeadsResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($propertyLeadsRow = mysql_fetch_array($propertyLeadsResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($propertyLeadsRow);
//            try{
//                
//                        $data = $propertyLeadsRow;
//                        $data['property_id'] = $data['pid'];
//                        $data['branch_id'] = $data['bid'];
//                        $data['tel'] = $data['telephone'];
//                        $data['created_at'] = date('Y-m-d H:i:s',$data['enquiry_date']);
//                        $propertyLeadsService->saveLeadFromArray($data);
//                        
//                       
//                        
//                }
//            catch(Exception $e){
//                var_dump($propertyLeadsRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $userService = $this->_service->getService('User_Service_User');
//        $userQuery = "select * from users";
//        $userResult = mysql_query($userQuery);
//        if (!$userResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($userRow = mysql_fetch_array($userResult,MYSQLI_ASSOC)){
////            Zend_Debug::dump($userRow);
//            try{
//                
//                        $data = $userRow;
//                        if($data['profileid']!=null && $staffService->getStaff($data['profileid'])){
//                            $data['staff_id'] = $data['profileid'];
//                        }
//                        
//                        if($data['activated']>0){
//                            $data['activated'] = 1;
//                        }
//                        
//                        $user = $userService->saveUserFromArray($data);
//                        $user->set('id',$data['id']);
//                        $user->save();
//                }
//            catch(Exception $e){
//                var_dump($userRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//        $agentUsersQuery = "select * from agentusers";
//        $agentUserResult = mysql_query($agentUsersQuery);
//        if (!$userResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($agentUserRow = mysql_fetch_array($agentUserResult,MYSQLI_ASSOC)){
////            Zend_Debug::dump($agentUserRow);
//            try{
//                    $data = $agentUserRow;
//                    if($user = $userService->getUser($data['userid'])){
//                        if(strlen($data['bid'])){
//                            $user->set('branch_id',$data['bid']);
//                        }
//                        if(strlen($data['aid'])){
//                            $user->set('agent_id',$data['aid']);
//                        }
//                        $user->save();
//                    }
//                }
//            catch(Exception $e){
//                var_dump($userRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
        // user finish
        
        
        // minor tables start
        
//        $bannedService = $this->_service->getService('Default_Service_Banned');
//        $bannedQuery = "select * from banned";
//        $bannedResult = mysql_query($bannedQuery);
//        if (!$bannedResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($bannedRow = mysql_fetch_array($bannedResult,MYSQLI_ASSOC)){
////            Zend_Debug::dump($bannedRow);
//            try{
//                    $data = $bannedRow;
//                    $bannedService->saveBannedFromArray($data);
//                }
//            catch(Exception $e){
//                var_dump($bannedRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//        $compareFeesService = $this->_service->getService('Default_Service_CompareFees');
//        $compareFeesQuery = "select * from fees f inner join fee_compare_personal_details fc on fc.id = f.id";
//        $compareFeesResult = mysql_query($compareFeesQuery);
//        if (!$compareFeesResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($compareFeesRow = mysql_fetch_array($compareFeesResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($compareFeesRow);
//            try{
//                    $data = $compareFeesRow;
//                    if($data['date']!=null){
//                        $data['created_at'] = date('Y-m-d H:i:s',$data['date']);
//                    }
//                    
//                    $compareFeesService->saveFeesFromArray($data);
//                }
//            catch(Exception $e){
//                var_dump($compareFeesRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $lockoutService = $this->_service->getService('Default_Service_Lockout');
//        $lockoutQuery = "select * from lock_outs";
//        $lockoutResult = mysql_query($lockoutQuery);
//        if (!$lockoutResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($lockoutRow = mysql_fetch_array($lockoutResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($lockoutRow);
//            try{
//                    $data = $lockoutRow;
//                    $data['created_at'] = date('Y-m-d H:i:s',$data['when']);
//                    $lockoutService->saveLockoutFromArray($data);
//                }
//            catch(Exception $e){
//                var_dump($lockoutRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $lockoutService = $this->_service->getService('Default_Service_Lockout');
//        $lockoutQuery = "select * from lock_outs";
//        $lockoutResult = mysql_query($lockoutQuery);
//        if (!$lockoutResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($lockoutRow = mysql_fetch_array($lockoutResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($lockoutRow);
//            try{
//                    $data = $lockoutRow;
//                    $data['created_at'] = date('Y-m-d H:i:s',$data['when']);
//                    $lockoutService->saveLockoutFromArray($data);
//                }
//            catch(Exception $e){
//                var_dump($lockoutRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//        $postcodeService = $this->_service->getService('Default_Service_Postcode');
//        $postcodeQuery = "select * from postcodes group by postcode";
//        $postcodeResult = mysql_query($postcodeQuery);
//        if (!$postcodeResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($postcodeRow = mysql_fetch_array($postcodeResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($postcodeRow);
//            try{
//                    $data = $postcodeRow;
//                    $data['lat'] = $data['latitude'];
//                    $data['lng'] = $data['longitude'];
//                    $postcodeService->savePostcodeFromArray($data);
//                }
//            catch(Exception $e){
//                var_dump($postcodeRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $postcodeCountQuery = "select * from postcodes_count ";
//        $postcodeCountResult = mysql_query($postcodeCountQuery);
//        if (!$postcodeCountResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($postcodeCountRow = mysql_fetch_array($postcodeCountResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($postcodeCountRow);
//            try{
//                    $data = $postcodeCountRow;
//                    $data['postcode'] = $data['postcode1'];
//                    $postcodeService->savePostcodeCountFromArray($data);
//                }
//            catch(Exception $e){
//                var_dump($postcodeCountRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
        
        $redirectService = $this->_service->getService('Default_Service_Redirect');
//        $redirectQuery = "select * from redirects ";
//        $redirectResult = mysql_query($redirectQuery);
//        if (!$redirectResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($redirectRow = mysql_fetch_array($redirectResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($redirectRow);
//            try{
//                    $data = $redirectRow;
//                    $data['agent_id'] = $data['aid'];
//                    $data['branch_id'] = $data['bid'];
//                    $redirectService->saveRedirectFromArray($data);
//                }
//            catch(Exception $e){
//                var_dump($redirectRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//        $redirectStaffQuery = "select * from redirects_staff ";
//        $redirectStaffResult = mysql_query($redirectStaffQuery);
//        if (!$redirectStaffResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($redirectStaffRow = mysql_fetch_array($redirectStaffResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($redirectStaffRow);
//            try{
//                    $data = $redirectStaffRow;
//                    $data['old_link'] = $data['oldname'];
//                    $data['new_link'] = $data['newname'];
//                    $data['old_staff_id'] = $data['oldprofileid'];
//                    $data['new_staff_id'] = $data['newprofileid'];
//                    $redirectService->saveRedirectStaffFromArray($data);
//                }
//            catch(Exception $e){
//                var_dump($redirectStaffRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//        $testimonialService = $this->_service->getService('Default_Service_Testimonial');
//        $testimonialQuery = "select * from testimonials";
//        $testimonialResult = mysql_query($testimonialQuery);
//        if (!$testimonialResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($testimonialRow = mysql_fetch_array($testimonialResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($testimonialRow);
//            try{
//                    $data = $testimonialRow;
//                    $testimonial = $testimonialService->saveTestimonialFromArray($data);
//                    $testimonial->set('id',$data['id']);
//                    $testimonial->save();
//                }
//            catch(Exception $e){
//                var_dump($testimonialRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
//         $testimonialCommentQuery = "select * from testimonial_comments";
//        $testimonialCommentResult = mysql_query($testimonialCommentQuery);
//        if (!$testimonialCommentResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($testimonialCommentRow = mysql_fetch_array($testimonialCommentResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($testimonialCommentRow);
//            try{
//                    $data = $testimonialCommentRow;
//                    $data['testimonial_id'] = $data['tid'];
//                    $testimonial = $testimonialService->saveTestimonialCommentFromArray($data);
//                    $testimonial->set('id',$data['id']);
//                    $testimonial->save();
//                }
//            catch(Exception $e){
//                var_dump($testimonialCommentRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
        $alertService = $this->_service->getService('Review_Service_Alert');
//        $alertQuery = "select * from alerts group by email";
//        $alertResult = mysql_query($alertQuery);
//        if (!$alertResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($alertRow = mysql_fetch_array($alertResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($alertRow);
//            try{
//                if(!strlen($alertRow['email']))
//                    continue;
//                    $data = $alertRow;
//                    $data['agent_id'] = $data['agent'];
//                    $data['branch_id'] = $data['branch'];
//                    $alert = $alertService->saveAlertFromArray($data);
//                    $alert->set('id',$data['aid']);
//                    $alert->save();
//                }
//            catch(Exception $e){
//                var_dump($alertRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
        
//        $alertSendQuery = "select * from alerts_to_send";
//        $alertSendResult = mysql_query($alertSendQuery);
//        if (!$alertSendResult) {
//            $message  = 'Invalid query: ' . mysql_error() . "\n";
//            die($message);
//        }
//        
//        while($alertSendRow = mysql_fetch_array($alertSendResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($alertSendRow);
//            try{
//                    $data = $alertSendRow;
//                    $data['review_id'] = $data['rid'];
//                    $alertService->saveAlertToSendFromArray($data);
//                }
//            catch(Exception $e){
//                var_dump($alertSendRow);
//                var_dump($e->getMessage());exit;
//            }
//        }
//        
        // minor tables finish
        echo "done";exit;
        
        
        
        
        
        
        
        
        
        
        
        
        echo "googd";exit;
//           $videoService = $this->_service->getService('Gallery_Service_Video');
//    $promotedVideo = $videoService->getPromotedVideo();
//    
//        $this->view->assign('promotedVideo', $promotedVideo);
      
        
        
    }
    
    public function scanAgentPhotosAction(){
        $photoService = $this->_service->getService('Media_Service_Photo');
        $files = scandir(APPLICATION_PATH."/../public_html/media/photos/agent");
        foreach($files as $file):
            if($file=="."||$file=="..")
                continue;
            
            $data = array();
            $data['offset'] = "agent";
            $data['filename'] = $file;
            $data['lft'] = 1;
            $data['rgt'] = 2;
            $data['level'] = 0;
            $photoService->saveFromArray($data);
//            var_dump($file);exit;
        endforeach;
        echo "done";exit;
    }
    
//    public function assignPhotoToAgentAction(){
//        
//        $agentService = $this->_service->getService('Agent_Service_Agent');
//        
//        $agents = $agentService->getAllAgents();
//        foreach($agents as $agent):
//            
//        endforeach;
//    }
    
    
    function moveAdvertising(){
        // advertising start
        
        ini_set('max_execution_time',1500);
        ini_set('memory_limit', '1024M');
        $handle = mysql_connect('192.168.200.18','root','#12let123!#','allagent_db1') or die(mysql_error());
        mysql_select_db('allagent_db1');
        mysql_set_charset('UTF8');
        
        
        $advertisingService = $this->_service->getService('Advertising_Service_Advertising');
        $advertisingQuery = "select * from advertising a left join advertising_sponsors ass on ass.ad_id = a.id";
        $advertisingResult = mysql_query($advertisingQuery);
        if (!$advertisingResult) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            die($message);
        }
        
        while($advertisingRow = mysql_fetch_array($advertisingResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($advertisingRow);
            try{
                
                        $data = $advertisingRow;
                        
                        $advertising = $advertisingService->saveAdvertisingFromArray($data);
//                        $advertising->set('id',$data['id']);
//                        $advertising->save();
                        $newData = array();
                        if($data['type']=="agent"){
                            $newData['agent_id'] = $data['value'];
                            $newData['ad_id'] = $advertising['id'];
                            $advertisingService->saveAdvertisingAgentFromArray($newData);
                        }
                        elseif($data['type']=="branch"){
                            $newData['branch_id'] = $data['value'];
                            $newData['ad_id'] = $advertising['id'];
                            $advertisingService->saveAdvertisingBranchFromArray($newData);
                        }
                        elseif($data['type']=="town"){
                            $newData['city'] = $data['value'];
                            $newData['ad_id'] = $advertising['id'];
                            $advertisingService->saveAdvertisingCityFromArray($newData);
                        }
                        
                        $advertisingSubQuery = "select * from advertising_settings ass inner join advertising_pages ap on ap.page_id = ass.id where ap.id_ad = ".$advertisingRow['id'];
                        $advertisingSubResult = mysql_query($advertisingSubQuery);
                        
                        while($advertisingSubRow = mysql_fetch_array($advertisingSubResult,MYSQLI_ASSOC)){
                            if($advertisingSubRow['setting_id'] == 2){
                                $subData = array();
                                $subData['page'] = $advertisingSubRow['name'];
                                $subData['value'] = $advertisingSubRow['value'];
                                $page = $advertisingService->saveAdvertisingPageFromArray($subData);
                                $advertising->link('Pages',$page['id']);
                                $advertising->save();
                            }
                        }
                        
                        $advertisingSub2Query = "select * from advertising_settings ass where ass.id = ".$advertisingRow['location'];
                        $advertisingSub2Result = mysql_query($advertisingSub2Query);
                        
                        while($advertisingSub2Row = mysql_fetch_array($advertisingSub2Result,MYSQLI_ASSOC)){
                            if($advertisingSub2Row['setting_id'] == 1){
                                $sub2Data = array();
                                $sub2Data['position'] = $advertisingSub2Row['name'];
                                $sub2Data['value'] = $advertisingSub2Row['value'];
                                $position = $advertisingService->saveAdvertisingPositionFromArray($sub2Data);
                                $advertising->set('position_id',$position['id']);
                                $advertising->save();
                            }
                        }
                        
                        
                        
                        $advertisingSub3Query = "select * from advertising_settings ass where ass.id = ".$advertisingRow['ad_size'];
                        $advertisingSub3Result = mysql_query($advertisingSub3Query);
                        
                        while($advertisingSub3Row = mysql_fetch_array($advertisingSub3Result,MYSQLI_ASSOC)){
                            if($advertisingSub3Row['setting_id'] == 3){
                                $sub3Data = array();
                                $sub3Data['size'] = $advertisingSub3Row['name'];
                                $sub3Data['value'] = $advertisingSub3Row['value'];
                                $size = $advertisingService->saveAdvertisingSizeFromArray($sub3Data);
                                $advertising->set('size_id',$size['id']);
                                $advertising->save();
                            }
                        }
                        
//                        $advertising->set('id',$data['id']);
//                        $advertising->save();
                }
            catch(Exception $e){
                var_dump($advertisingRow);
                var_dump($e->getMessage());exit;
            }
        }
        
        
        
        // advertising finish
    }
    function reslugAdSource(){
        $advertisingService = $this->_service->getService('Advertising_Service_Advertising');
          $ads =   $advertisingService->getAllAdvertisings();
            
            foreach($ads as $ad):
               $source = $ad['source'];
                $source = str_replace(array("/images", "/ads"), "", $source);
                $source = MF_Text::createSlug($source);
                $ad->set('source',$source);
                $ad->save();
            endforeach;
        }
        
        
    function setAgentMember(){
        ini_set('max_execution_time',1500);
        ini_set('memory_limit', '1024M');
        $handle = mysql_connect('localhost','root','','allagents') or die(mysql_error());
        mysql_select_db('allagents');
        mysql_set_charset('UTF8');
        
        $agentService = $this->_service->getService('Agent_Service_Agent');
        
        $advertisingQuery = "select ";
        $fields = array('naea','arla','safeagent','oft','propombudsman','franchise','independant','nla','sal','dps','mydeposits','sacda','gpea','type_let','type_sales','type_mort','type_block','type_surv','type_conv','independent','corporate','rics','arma','nals','ukala','tpos_sales','tpos_lettings','tds','lps_scotland','zoopla','rightmove','home_sale_network','national_homes_network','onthemarket','move_with_us');
        foreach($fields as $key=>$field):
            if($key!=0)
                $advertisingQuery .= ",";
            $advertisingQuery .= "sum(".$field.") as sum_".$field;
        endforeach;
        
        $advertisingQuery .= ",b.agent_id from branch_member bm inner join branch_branch b on bm.branch_id = b.id where agent_id IS NOT NULL group by agent_id";
//        echo $advertisingQuery;exit;
        $advertisingResult = mysql_query($advertisingQuery);
        if (!$advertisingResult) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            die($message);
        }
        
        while($advertisingRow = mysql_fetch_array($advertisingResult,MYSQLI_ASSOC)){
//            Zend_Debug::dump($advertisingRow);
            
            try{
                
                        $data = $advertisingRow;
                        $agent = $agentService->getAgent($data['agent_id']);
                        if(!$agent)
                            continue;
                        $member = array();
                        foreach($data as $key=>$value):
                            if($key==['agent_id']){
                                continue;
                            }
                            
                            if($value>0){
                                $fieldName = substr($key,4);
                                $member[$fieldName] = 1;
                            }
                        endforeach;
                        $agent->get('Member')->fromArray($member);
                                $agent->save();
//                        var_dump($data);exit;
                }
            catch(Exception $e){
//                var_dump($advertisingRow);
//                var_dump($e->getMessage());exit;
         
            }
        }
    }
    
    function moveReviews(){
        ini_set('max_execution_time',1500);
        ini_set('memory_limit', '1024M');
        $handle = mysql_connect('192.168.200.18','root','#12let123!#','allagent_db1') or die(mysql_error());
        mysql_select_db('allagent_db1');
        mysql_set_charset('UTF8');
        
        $reviewService = $this->_service->getService('Review_Service_Review');
        $reviewQuery = "select * from reviews ";
        $reviewResult = mysql_query($reviewQuery);
        if (!$reviewResult) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            die($message);
        }
        
        while($reviewRow = mysql_fetch_array($reviewResult,MYSQLI_ASSOC)){
            try{
                
                        $data = $reviewRow;
                        $data['agent_id'] = $data['agent'];
                        if($data['fee_satisfaction']=="-1"){
                            $data['fee_satisfaction'] = null;
                        }
                        if($data['best_price']=="-1"){
                            $data['best_price'] = null;
                        }
                        if($data['featuretime']==0){
                            $data['featuretime'] = null;
                        }
                        else{
                            $data['featuretime'] = date('Y-m-d H:i:s',$data['featuretime']);
                        }
                        
                        if($data['featured']!=0){
                            $data['featured'] = 1;
                        }
                        $data['staff'] = (int)$data['staff'];
                        $data['staff2'] = (int)$data['staff2'];
                        $data['branch_id'] = (int)$data['branch'];
                        $review = $reviewService->saveReviewFromArray($data);
                        $review->set('id',$data['rid']);
                        $review->save();
                }
            catch(Exception $e){
                var_dump($reviewRow);
                var_dump($e->getMessage());exit;
            }
        }
    }
    
    function moveProperties(){
//        ini_set('max_execution_time',1500);
        ini_set('memory_limit', '1024M');
        $handle = mysql_connect('192.168.200.18','root','#12let123!#','allagent_db1') or die(mysql_error());
        mysql_select_db('allagent_db1');
        mysql_set_charset('UTF8');
        
        $propertyService = $this->_service->getService('Property_Service_Property');
        $featureService = $this->_service->getService('Property_Service_Feature');
        $letService = $this->_service->getService('Property_Service_Let');
        $saleService = $this->_service->getService('Property_Service_Sale');
        $propertyQuery = "select * from property p left join prop_description pd on p.pid = pd.pid left join prop_lettings pl on pl.pid = pd.pid left join prop_sales ps on ps.pid = pl.pid";
        $propertyResult = mysql_query($propertyQuery);
        if (!$propertyResult) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            die($message);
        }
        while($propertyRow = mysql_fetch_array($propertyResult,MYSQLI_ASSOC)){
            Zend_Debug::dump($propertyRow);
            try{
                
                        $data = $propertyRow;
                        $data['agent_id'] = $data['aid'];
                        $data['branch_id'] = (int)$data['bid'];
                        $data['branch_identify'] = $propertyRow['branch_id'];
                        $data['published'] = $propertyRow['published_flag'];
                        $data['search_price'] = $propertyRow['searchprice'];
                        if($data['create_date']>0){
                            $data['created_at'] = date('Y-m-d H:i:s',$data['create_date']);
                        }
                        if($data['update_date']>0){
                            $data['updated_at'] = date('Y-m-d H:i:s',$data['update_date']);
                        }
                        $property = $propertyService->savePropertyFromArray($data);
                        
                        for($i=1;$i<=10;$i++):
                            if(strlen($data['feature'.$i])){
                                $featData = array();
                                $featData['property_id'] = $property['id'];
                                $featData['feature'] = $data['feature'.$i];
                                $featureService->saveFeatureFromArray($featData);
                            }
                        endfor;
                        
                        $letData = array();
                        foreach ($data as $key => $value) {
                            if (strpos($key, 'let_') === 0) {
                                $letData[substr($key,4)] = $value;
                            }
                        }
                        if($letData['expired']>0)
                            $letData['expired'] = 1;
                        
                        $letData['property_id'] = $property['id'];
                        $data['property_id'] = $property['id'];
                        
                        if(strlen($letData['date_available'])==4){
                            $letData['date_available'] = $letData['date_available']."-01-01 00:00";
                        }
                        elseif($letData['date_available']==0){
                            $letData['date_available'] = null;
                        }
                        elseif(strlen($letData['date_available'])==10){
                            $letData['date_available'] = date('Y-m-d H:i:s',$letData['date_available']);
                        }
                        
                        $letService->saveLetFromArray($letData);
                        $saleService->saveSaleFromArray($data);
                        
                }
            catch(Exception $e){
                var_dump($propertyRow);
                var_dump($e->getMessage());exit;
            }
        }
    }
    
    function moveReviewComments(){
        ini_set('max_execution_time',1500);
        ini_set('memory_limit', '1024M');
        $handle = mysql_connect('192.168.200.18','root','#12let123!#','allagent_db1') or die(mysql_error());
        mysql_select_db('allagent_db1');
        mysql_set_charset('UTF8');
        
        $reviewCommentService = $this->_service->getService('Review_Service_Comment');
        $reviewCommentQuery = "select * from comments ";
        $reviewCommentResult = mysql_query($reviewCommentQuery);
        if (!$reviewCommentResult) {
            $message  = 'Invalid query: ' . mysql_error() . "\n";
            die($message);
        }
        
        while($reviewCommentRow = mysql_fetch_array($reviewCommentResult,MYSQLI_ASSOC)){
            Zend_Debug::dump($reviewCommentRow);
            try{
                
                        $data = $reviewCommentRow;
                        $data['review_id'] = $data['review'];
                        if($data['activated']>0){
                            $data['activated'] = 1;
                        }
                        $data['review_id'] = $data['review'];
                        $data['created_at'] = date('Y-m-d H:i:s',$data['date']);
                        $comment = $reviewCommentService->saveCommentFromArray($data);
                        $comment->set('id',$data['cid']);
                        $comment->save();
                }
            catch(Exception $e){
                var_dump($reviewCommentRow);
                var_dump($e->getMessage());exit;
            }
        }
    }
}
