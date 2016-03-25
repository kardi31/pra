<?php

/**
 * Banner_AdminController
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_AdminController extends MF_Controller_Action {
   
     public function init() {
        $this->_helper->ajaxContext()
                ->addActionContext('move-category', 'json')
                ->initContext();
        parent::init();
        
        $authService = $this->_service->getService('User_Service_Auth');
        $this->user = $authService->getAuthenticatedUser();
    }
     public function listCategoryAction() {
        $agentService = $this->_service->getService('Agent_Service_Agent');
//        
        $form = $agentService->getAgentItemForm();
        $form->setAction($this->view->adminUrl('add-category', 'agent', array()));
        
        $categoryRoot = $agentService->getAllMainCategories();
        
//        
        $this->view->assign('categoryRoot', $categoryRoot);
        $this->view->assign('form', $form);
    }
    
  
   public function listCategoryDataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $table = Doctrine_Core::getTable('Agent_Model_Doctrine_Category');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Agent_DataTables_Category', 
            'columns' => array('x.id','xt.title'),
            'searchFields' => array('x.id','xt.title')
        ));
        
        $results = $dataTables->getResult();
        $language = $i18nService->getAdminLanguage();

        $rows = array();
        foreach($results as $result) {
            
            $row = array();
            $row[] = $result->id;
            $row[] = $result->Translation[$language->getId()]->title;
           
            
                $options = '<a href="' . $this->view->adminUrl('edit-category', 'agent', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                $options .= '<a href="' . $this->view->adminUrl('remove-category', 'agent', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            
             $row[] = $options;
            $rows[] = $row;
        }

         $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $dataTables->getTotal(),
            "aaData" => $rows
        );

        $this->_helper->json($response);
        
    }
    
    public function calculateAgentWeeklyRankingsAction(){
        $reviewService = $this->_service->getService('Review_Service_Review');
        $rankingService = $this->_service->getService('Agent_Service_Ranking');
        
        
        $week = 28;
        $year = 2015;
//        $week = date('W')-1;
//        $year = date('Y');
        if($week==0){
            $week = 52;
            $year = $year-1;
        }
        $weeklyCalculations = $reviewService->calculateAgentWeeklyRanking($week,$year);
        
        foreach($weeklyCalculations as $key => $calculation){
            $values = array();
            $values['week'] = $week;
            $values['year'] = $year;
            $values['agent_id'] = $calculation['agent_id'];
            $values['position'] = $key+1;
            $rankingService->saveWeeklyRankingFromArray($values);
        }
        die('done');
    }
    
    public function calculateAgentMonthlyRankingsAction(){
        $reviewService = $this->_service->getService('Review_Service_Review');
        $rankingService = $this->_service->getService('Agent_Service_Ranking');
        
        
        $month = 7;
        $year = 2015;
//        $week = date('M')-1;
//        $year = date('Y');
        if($month==0){
            $month = 12;
            $year = $year-1;
        }
        $monthlyCalculations = $reviewService->calculateAgentMonthlyRanking($month,$year);
        foreach($monthlyCalculations as $key => $calculation){
            $values = array();
            $values['month'] = $month;
            $values['year'] = $year;
            $values['agent_id'] = $calculation['agent_id'];
            $values['position'] = $key+1;
            $rankingService->saveMonthlyRankingFromArray($values);
        }
        die('done');
    }
    
     
    public function addCategoryAction() {
        $agentService = $this->_service->getService('Agent_Service_Agent');
//
        $form = $agentService->getAgentItemForm();
//
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                     
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                     $data = $form->getValues();
                    $category = $agentService->saveCategoryFromArray($data);

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    if($this->getRequest()->getParam('saveOnly') == '1')
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-category', 'agent', array('id' => $category['id'] )));
                    
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-category', 'agent', array()));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function editCategoryAction() {
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $translator = $this->_service->get('translate');
        
        if(!$agent = $agentService->getCategory($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Agent not found');
        }
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $agentService->getAgentItemForm($agent);
        
        $metatagsForm = $metatagService->getMetatagsSubForm($agent->get('Metatags'));
        $form->addSubForm($metatagsForm, 'metatags');
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    
                    
                    
                    $metatagValues['translations']['pl'] = $values;
                    $metatagValues['metatags'] = $values['metatags']; 
                    if($metatags = $metatagService->saveMetatagsFromArray($category->get('Metatags'), $metatagValues, array('title' => 'title', 'description' => 'content', 'keywords' => 'content'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    
                    $category = $agentService->saveCategoryFromArray($values);
                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                   
                    
                     if(isset($_POST['save_only'])){
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-category', 'agent',array('id' => $category->id)));
                    }

                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-category', 'agent'));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('category', $category);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function removeCategoryAction() {
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        if($category = $agentService->getCategory($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                $metatag = $metatagService->getMetatag((int) $category->getMetatagId());

                $metatagService->removeMetatag($metatag);
                
                $category->delete();


                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-category', 'agent'));
            } catch(Exception $e) {
                var_dump($e->getMessage());exit;
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function moveCategoryAction() {
        $agentService = $this->_service->getService('Agent_Service_Agent');
     
        $this->view->clearVars();
        
        $status = 'success';
        
        $category = $agentService->getCategory((int) $this->getRequest()->getParam('id'));
        
        $dest = $agentService->getCategory((int) $this->getRequest()->getParam('dest_id'));
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
            
            $agentService->moveCategory($category, $dest, $this->getRequest()->getParam('mode', 'after'));

            $this->_service->get('doctrine')->getCurrentConnection()->commit();
        } catch(Exception $e) {
            var_dump($e->getMessage());exit;
            $this->_service->get('doctrine')->getCurrentConnection()->rollback();
            $this->_service->get('log')->log($e->getMessage());
            $status= 'error';
        }
        
        $this->view->assign('status', $status);
    }
    
    public function listUpdateAction() {

    }
    
    public function listUpdateDataAction() {    
        $i18nService = $this->_service->getService('Default_Service_I18n');
       
        $table = Doctrine_Core::getTable('Agent_Model_Doctrine_Update');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Agent_DataTables_Update', 
            'columns' => array('x.id','x.name', 'x.town','x.address'),
            'searchFields' => array('x.id','x.name', 'x.town','x.address')
        ));
        
        $language = $i18nService->getAdminLanguage();
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row[] = $result->id;
            $row[] = $result->name;
            $row[] = $result->town;
            $row[] = $result->address;
            $row[] = count($result['Branches']);
            $row[] = MF_Text::timeFormat($result['created_at'],'d/m/Y H:i');
            $options = '<a href="' . $this->view->adminUrl('edit-update', 'agent', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-update', 'agent', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $dataTables->getTotal(),
            "aaData" => $rows
        );

        $this->_helper->json($response);
    }
    
    public function editUpdateAction() {
        $updateService = $this->_service->getService('Agent_Service_Update');
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $hoursService = $this->_service->getService('Branch_Service_OpeningHours');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        
        if(!$update = $updateService->getUpdate($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Ad not found');
        }
        
        $form = $updateService->getUpdateForm($update);
       
        $this->view->assign('form',$form);
        
       
        $languages = $i18nService->getLanguageList();
        $adminLanguage = $i18nService->getAdminLanguage();
        $this->view->assign('languages', $languages);
        $this->view->assign('adminLanguage', $adminLanguage);
        
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {                                   
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    $values = $form->getValues();  
                    unset($values['id']);
                    $agent = $agentService->saveNewAgentFromUpdate($values);
                    
                    $branch = $branchService->saveNewAgentBranchFromUpdate($agent['id'],$values);
                    
                    $values['hoursForm']['branch_id'] = $branch['id'];
                    $hoursService->saveOpeningHoursFromArray($values['hoursForm']);
                    
                    $agent->set('HeadOffice',$branch);
                    $agent->save();
                    
                    
                    foreach($form->getSubForms() as $subForm){
                        if($subForm->getName()!='translations' && $subForm->getName() !='hoursForm'){
                            $newValues = $values[$subForm->getName()];
                            $branch = $branchService->saveNewAgentBranchFromUpdate($agent['id'],$newValues);
                    
                            $newValues['hoursForm']['branch_id'] = $branch['id'];
                            $hoursService->saveOpeningHoursFromArray($newValues['hoursForm']);
                        }
                    }
                    if($update->get('Branches')){
                        $update->get('Branches')->delete();
                    }
                    $update->delete();
            
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-update', 'agent'));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
    }
    
     public function removeUpdateAction() {
        $updateService = $this->_service->getService('Agent_Service_Update');
        
        
        if(!$update = $updateService->getUpdate($this->getRequest()->getParam('id'))) {
            $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-update', 'agent'));
        }
        
        if($update->get('Branches')){
            $update->get('Branches')->delete();
        }
        $update->delete();
        
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-update', 'agent'));
         
        $this->_helper->viewRenderer->setNoRender();
               
    }
    
    public function listAgentAction() {

    }
    
    public function listAgentDataAction() {    
        $i18nService = $this->_service->getService('Default_Service_I18n');
       
        $table = Doctrine_Core::getTable('Agent_Model_Doctrine_Agent');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Agent_DataTables_Agent', 
            'columns' => array('x.id','x.name', 'x.active','x.approved','x.premium_support','b.id','u.id','x.created_at','x.updated_at'),
            'searchFields' => array('x.id','x.name', 'x.active','x.approved','x.premium_support','b.id','u.id','x.created_at','x.updated_at')
        ));
        
        $language = $i18nService->getAdminLanguage();
        
        $results = $dataTables->getResult();
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row[] = $result->id;
            $row[] = $result->name;
            if($result->view)
                $row[] = '<a href="' . $this->view->adminUrl('set-agent-active', 'agent', array('id' => $result->id)) . '" title="' . $this->view->translate('Set inactive') . '"><span class="icon16 icomoon-icon-checkbox-2"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            else
                $row[] = '<a href="' . $this->view->adminUrl('set-agent-active', 'agent', array('id' => $result->id)) . '" title="' . $this->view->translate('Set active') . '"><span class="icon16 icomoon-icon-checkbox-unchecked"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            
            if($result->approved)
                $row[] = '<span class="icon16 icomoon-icon-checkbox-2"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            else
                $row[] = '<a href="' . $this->view->adminUrl('approve-agent', 'agent', array('id' => $result->id)) . '" title="' . $this->view->translate('Set active') . '"><span class="icon16 icomoon-icon-checkbox-unchecked"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
             
            if($result->premium_support)
                $row[] = '<a href="' . $this->view->adminUrl('set-agent-premium', 'agent', array('id' => $result->id)) . '" title="' . $this->view->translate('Set inactive') . '"><span class="icon16 icomoon-icon-checkbox-2"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            else
                $row[] = '<a href="' . $this->view->adminUrl('set-agent-premium', 'agent', array('id' => $result->id)) . '" title="' . $this->view->translate('Set active') . '"><span class="icon16 icomoon-icon-checkbox-unchecked"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            
            
            $row[] = count($result['Branches']);
            if($result['User']){
                $row[] = $result['User']['email'];
            }
            else{
                $row[] = '<a href="' . $this->view->adminUrl('create-agent-user', 'agent', array('id' => $result->id)) . '" title="' . $this->view->translate('Set active') . '">Stwórz użytkownika</a>';
            }
            $row[] = MF_Text::timeFormat($result['created_at'],'d/m/Y H:i');
            $row[] = MF_Text::timeFormat($result['updated_at'],'d/m/Y H:i');
            $options = '<a href="' . $this->view->adminUrl('edit-agent', 'agent', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-agent', 'agent', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            $row[] = $options;
            $rows[] = $row;
        }

        $response = array(
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => $dataTables->getDisplayTotal(),
            "iTotalDisplayRecords" => $dataTables->getTotal(),
            "aaData" => $rows
        );

        $this->_helper->json($response);
    }
    
    public function setAgentActiveAction() {
        $agentService = $this->_service->getService('Agent_Service_Agent');
        
        if($agent = $agentService->getAgent($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                if($agent->view){
                    $agent->set('view',0);
                }
                else{
                    $agent->set('view',1);
                }
                    
                $agent->save();

                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-agent', 'agent'));
            } catch(Exception $e) {
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function setAgentPremiumAction() {
        $agentService = $this->_service->getService('Agent_Service_Agent');
        
        if($agent = $agentService->getAgent($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                if($agent->premium_support){
                    $agent->set('premium_support',0);
                }
                else{
                    $agent->set('premium_support',1);
                }
                    
                $agent->save();

                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-agent', 'agent'));
            } catch(Exception $e) {
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function approveAgentAction() {
        $userService = $this->_service->getService('User_Service_User');
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $mailService = $this->_service->getService('User_Service_Mail');
        
        if($agent = $agentService->getAgent($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                if($agent->approved){
                    $agent->set('approved',0);
                }
                else{
                    $agent->set('approved',1);
                    $agent->set('view',1);
                    
                    
                    $isAgentUser = $userService->getUser($agent['id'],'agent_id');
                    if(!$isAgentUser){
                        $branch = $agent['Branches'][0];
                        $branchUser = $userService->getUser($branch['id'],'branch_id');
                        if($branchUser){
                            $branchUser->set('agent_id',$agent['id']);
                            $branchUser->set('branch_id',null);
                            $branchUser->save();
                        }
                    }
                }
                
                $agent->save();

                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-agent', 'agent'));
            } catch(Exception $e) {
                var_dump($e->getMessage());exit;
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function editAgentAction() {
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $hoursService = $this->_service->getService('Branch_Service_OpeningHours');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        
        if(!$agent = $agentService->getAgent($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Ad not found');
        }
        
        $form = $agentService->getAgentAdminForm($agent);
       
        $this->view->assign('form',$form);
        
       
        $languages = $i18nService->getLanguageList();
        $adminLanguage = $i18nService->getAdminLanguage();
        $this->view->assign('languages', $languages);
        $this->view->assign('adminLanguage', $adminLanguage);
        
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {                                   
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    $values = $form->getValues();  
                    $values['id'] = $agent['id'];
                    $agent = $agentService->saveAgentFromCms($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-agent', 'agent'));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
    }
    
    public function createAgentUserAction(){
        $userService = $this->_service->getService('User_Service_User');
        $mailService = $this->_service->getService('User_Service_Mail');
        $agentService = $this->_service->getService('Agent_Service_Agent');
        
        if($agent = $agentService->getAgent($this->getRequest()->getParam('id'))) {
            $isAgentUser = $userService->getUser($agent['id'],'agent_id');
            if(!$isAgentUser){
                $branch = $agent['Branches'][0];
                $branchUser = $userService->getUser($branch['id'],'branch_id');
                if($branchUser){
                    $branchUser->set('agent_id',$agent['id']);
                    $branchUser->set('branch_id',null);
                    $branchUser->save();
                }
                else{
                    $passwordEncoder = new User_PasswordEncoder();
                    $values['salt'] = MF_Text::createUniqueToken();
                    $values['token'] = MF_Text::createUniqueToken();
                    $values['role'] = 'agent';

                    $values['email'] = $branch['email'];
                    $values['agent_id'] = $agent['id'];

                    $newPassword = MF_Text::createRandomString();

                    $values['password'] = $passwordEncoder->encode($newPassword, $values['salt']);
                    $user = $userService->saveUserFromArray($values);

                    $options = $this->getFrontController()->getParam('bootstrap')->getOptions();
                    $mail = new Zend_Mail('UTF-8');
                    $mail->setSubject($this->view->translate('Your company account has been created on Rate Pole'));
                    $mail->addTo($branch['email'], $agent['name']);
                    $mail->setReplyTo($options['reply_email'], 'Oceń Fachowca');

                    $mailService->sendBranchAddedMail($user,$branch,$newPassword,$mail, $this->view);
                }
            }
            $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-agent', 'agent'));
        }
    }
}

