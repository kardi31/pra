<?php

/**
 * Review_AdminController
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Review_AdminController extends MF_Controller_Action {
   
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
        $commentService = $this->_service->getService('Review_Service_Review');
        $rankingService = $this->_service->getService('Agent_Service_Ranking');
        
        
        $week = 28;
        $year = 2015;
//        $week = date('W')-1;
//        $year = date('Y');
        if($week==0){
            $week = 52;
            $year = $year-1;
        }
        $weeklyCalculations = $commentService->calculateAgentWeeklyRanking($week,$year);
        
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
        $commentService = $this->_service->getService('Review_Service_Review');
        $rankingService = $this->_service->getService('Agent_Service_Ranking');
        
        
        $month = 7;
        $year = 2015;
//        $week = date('M')-1;
//        $year = date('Y');
        if($month==0){
            $month = 12;
            $year = $year-1;
        }
        $monthlyCalculations = $commentService->calculateAgentMonthlyRanking($month,$year);
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
    
    public function listReviewTempAction() {

    }
    
   public function listReviewTempDataAction() {    
        $i18nService = $this->_service->getService('Default_Service_I18n');
       
        $table = Doctrine_Core::getTable('Review_Model_Doctrine_Temp');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Review_DataTables_ReviewTemp', 
            'columns' => array('x.id','x.lastname', 'x.rating','x.email','a.name','b.office_name','x.activated','x.hostname','x.ip'),
            'searchFields' => array('x.id','x.lastname', 'x.rating','x.email','a.name','b.office_name','x.activated','x.hostname','x.ip')
        ));
        
        $language = $i18nService->getAdminLanguage();
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row[] = $result->id;
            $row[] = $result->firstname." ".$result->lastname;
            $row[] = $result->rating;
            $row[] = $result->email;
            $row[] = $result['Agent']->name;
            $row[] = $result['Branch']->office_name;
            $row[] = $result->activated;
            $row[] = $result->hostname;
            $row[] = $result->ip;
            $row[] = MF_Text::timeFormat($result['created_at'],'d/m/Y H:i');
            $options = '<a href="' . $this->view->adminUrl('edit-review-temp', 'review', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('delete-review-temp', 'review', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
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
    
    
    public function editReviewTempAction() {
        $tempService = $this->_service->getService('Review_Service_Temp');
        $commentService = $this->_service->getService('Review_Service_Review');
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $mailService = $this->_service->getService('User_Service_Mail');
        
        
        if(!$tempReview = $tempService->getReview($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Review not found');
        }
        
        if(!$agent = $agentService->getAgent($tempReview['agent_id'])) {
            throw new Zend_Controller_Action_Exception('Agent not found');
        }
        
        $form = $tempService->getReviewAdminForm($tempReview,$agent);
        
        $this->view->assign('review',$tempReview);
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
                    
                    $review = $commentService->saveReviewFromTemp($values);
                    
                    $options = $this->getFrontController()->getParam('bootstrap')->getOptions();
                    
                    $mail = new Zend_Mail('UTF-8');
                    $mail->setSubject($this->view->translate('Company')." ".$review['Agent'].' '.$this->view->translate('has been reviewed.'));
                    $mail->addTo($review['Branch']['email'], $review['Agent']['name']);
                    $mail->setReplyTo($review,$options['reply_email'], 'Oceń Fachowca');
//                    $mail->addTo('kardi31@o2.pl');
                    if($review['Staff']){
                        $mail->addTo($review['Staff']['email'], $review['Staff']['firstname']." ".$review['Staff']['lastname']);
                    }
                    
                    if($review['Staff2']){
                        $mail->addTo($review['Staff2']['email'], $review['Staff2']['firstname']." ".$review['Staff2']['lastname']);
                    }
                    
                    $mailService->sendReviewApprovedEmail($tempReview,$mail, $this->view);
                    
                    
                    $mailReviewer = new Zend_Mail('UTF-8');
                    $mailReviewer->setSubject($this->view->translate('Your review of')." ".$review['Agent'].' '.$this->view->translate('has been accepted.'));
                    $mailReviewer->addTo($review['email'], $review['display_name']);
                    $mailReviewer->setReplyTo($review,$options['reply_email'], 'Oceń Fachowca');
//                    $mail->addTo('kardi31@o2.pl');
                    
                    $mailService->sendReviewApprovedEmailForReviewer($tempReview,$mailReviewer, $this->view);
                    
                    $tempReview->delete();
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-review-temp', 'review'));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
    }
    
     public function deleteTempReviewAction() {
        $tempService = $this->_service->getService('Review_Service_Temp');
        
        
        if(!$tempReview = $tempService->getReview($this->getRequest()->getParam('id'))) {
            $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-review-temp', 'review'));
        }
        
        
        $tempReview->delete();
        
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-review-temp', 'review'));
         
        $this->_helper->viewRenderer->setNoRender();
               
    }
    
    public function listReviewAction() {

    }
    
   public function listReviewDataAction() {    
        $i18nService = $this->_service->getService('Default_Service_I18n');
       
        $table = Doctrine_Core::getTable('Review_Model_Doctrine_Review');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Review_DataTables_Review', 
            'columns' => array('x.id','x.lastname', 'x.rating','x.email','a.name','b.office_name','x.view','x.hostname','x.ip'),
            'searchFields' => array('x.id','x.lastname', 'x.rating','x.email','a.name','b.office_name','x.view','x.hostname','x.ip')
        ));
        
        $language = $i18nService->getAdminLanguage();
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row[] = $result->id;
            $row[] = $result->firstname." ".$result->lastname;
            $row[] = $result->rating;
            $row[] = $result->email;
            $row[] = $result['Agent']->name;
            $row[] = $result['Branch']->office_name;
            if($result->view)
                $row[] = '<a href="' . $this->view->adminUrl('set-review-active', 'review', array('id' => $result->id)) . '" title="' . $this->view->translate('Set inactive') . '"><span class="icon16 icomoon-icon-checkbox-2"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            else
                $row[] = '<a href="' . $this->view->adminUrl('set-review-active', 'review', array('id' => $result->id)) . '" title="' . $this->view->translate('Set active') . '"><span class="icon16 icomoon-icon-checkbox-unchecked"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            
            $row[] = $result->hostname;
            $row[] = $result->ip;
            $row[] = MF_Text::timeFormat($result['created_at'],'d/m/Y H:i');
            $options = '<a href="' . $this->view->adminUrl('edit-review', 'review', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('delete-review', 'review', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
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
    
    
    public function editReviewAction() {
        $tempService = $this->_service->getService('Review_Service_Temp');
        $commentService = $this->_service->getService('Review_Service_Review');
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $mailService = $this->_service->getService('User_Service_Mail');
        
        
        if(!$review = $commentService->getReview($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Review not found');
        }
        
        if(!$agent = $agentService->getAgent($review['agent_id'])) {
            throw new Zend_Controller_Action_Exception('Agent not found');
        }
        
        $form = $commentService->getReviewAdminForm($review,$agent);
        
        $this->view->assign('review',$review);
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
                    $values['id'] = $review['id'];
                    $review = $commentService->saveReviewFromArray($values);
                    
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-review', 'review'));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
    }
    
     public function deleteReviewAction() {
        $tempService = $this->_service->getService('Review_Service_Review');
        
        
        if(!$tempReview = $tempService->getReview($this->getRequest()->getParam('id'))) {
            $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-review', 'review'));
        }
        
        
        $tempReview->delete();
        
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-review', 'review'));
         
        $this->_helper->viewRenderer->setNoRender();
               
    }
    
    
    
    public function setReviewActiveAction() {
        $commentService = $this->_service->getService('Review_Service_Review');
        
        if($review = $commentService->getReview($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                if($review->view){
                    $review->set('view',0);
                }
                else{
                    $review->set('view',1);
                }
                    
                $review->save();


                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-review', 'review'));
            } catch(Exception $e) {
                var_dump($e->getMessage());exit;
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->viewRenderer->setNoRender();
    }
    
    
    public function listCommentAction() {

    }
    
   public function listCommentDataAction() {    
        $i18nService = $this->_service->getService('Default_Service_I18n');
       
        $table = Doctrine_Core::getTable('Review_Model_Doctrine_Comment');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Review_DataTables_Comment', 
            'columns' => array('x.id','x.name', 'x.email','r.rid','x.approved','x.view','x.hostname','x.ip'),
            'searchFields' => array('x.id','x.name','x.email','r.rid','x.approved','x.view','x.hostname','x.ip')
        ));
        
        $language = $i18nService->getAdminLanguage();
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row[] = $result->id;
            $row[] = $result->name;
            $row[] = $result->email;
             $row[] = '<a target="_blank" href="' . $this->view->url(array('id' => $result['Review']['id']), 'domain-review').'">'.$result['Review']['id'].'</a>';
          
            
            if($result->approve)
                $row[] = '<span class="icon16 icomoon-icon-checkbox-2"></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            else
                $row[] = '<a href="' . $this->view->adminUrl('approve-comment', 'review', array('id' => $result->id)) . '" title="' . $this->view->translate('Set active') . '"><span class="icon16 icomoon-icon-checkbox-unchecked"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            
            
            if($result->view)
                $row[] = '<a href="' . $this->view->adminUrl('set-comment-active', 'review', array('id' => $result->id)) . '" title="' . $this->view->translate('Set inactive') . '"><span class="icon16 icomoon-icon-checkbox-2"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            else
                $row[] = '<a href="' . $this->view->adminUrl('set-comment-active', 'review', array('id' => $result->id)) . '" title="' . $this->view->translate('Set active') . '"><span class="icon16 icomoon-icon-checkbox-unchecked"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            
            
            $row[] = $result->hostname;
            $row[] = $result->ip;
            $row[] = MF_Text::timeFormat($result['created_at'],'d/m/Y H:i');
            $options = '<a href="' . $this->view->adminUrl('edit-comment', 'review', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('delete-comment', 'review', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
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
    
    
    public function editCommentAction() {
        $commentService = $this->_service->getService('Review_Service_Comment');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        if(!$comment = $commentService->getComment($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Comment not found');
        }
        
        
        $form = $commentService->getCommentAdminForm($comment);
        
        $this->view->assign('comment',$comment);
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
                    
                    
                    $values['id'] = $comment['id'];
                    
                    
                    $comment = $commentService->saveCommentFromArray($values);
                    
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-comment', 'review'));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
    }
    
     public function deleteCommentAction() {
        $commentService = $this->_service->getService('Review_Service_Comment');
        
        
        if(!$comment = $commentService->getComment($this->getRequest()->getParam('id'))) {
            $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-comment', 'review'));
        }
        
        
        $comment->delete();
        
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-comment', 'review'));
         
        $this->_helper->viewRenderer->setNoRender();
               
    }
    
    
    
    public function setCommentActiveAction() {
        $commentService = $this->_service->getService('Review_Service_Comment');
        
        if($comment = $commentService->getComment($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                if($comment->view){
                    $comment->set('view',0);
                }
                else{
                    $comment->set('view',1);
                }
                    
                $comment->save();


                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-comment', 'review'));
            } catch(Exception $e) {
                var_dump($e->getMessage());exit;
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->viewRenderer->setNoRender();
    }
    
    
    public function approveCommentAction() {
        $mailService = $this->_service->getService('User_Service_Mail');
        $commentService = $this->_service->getService('Review_Service_Comment');
        
        if($comment = $commentService->getComment($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                if($comment->approve){
                    $comment->set('approve',0);
                }
                else{
                    $comment->set('approve',1);
                    
                    $options = $this->getFrontController()->getParam('bootstrap')->getOptions();
                    $mail = new Zend_Mail('UTF-8');
                    $mail->setSubject($this->view->translate('Your comment has been accepted.'));
                    $mail->addTo($comment['email'], $comment['name']);
                    $mail->setReplyTo($comment,$options['reply_email'], 'Oceń Fachowca');
//                    $mail->addTo('kardi31@o2.pl');
                    
                    $mailService->sendCommentApprovedEmail($comment,$mail, $this->view);
                    
                    
                    
                }
                    
                $comment->save();


                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-comment', 'review'));
            } catch(Exception $e) {
                var_dump($e->getMessage());exit;
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->viewRenderer->setNoRender();
    }
}

