<?php

class User_AccountController extends MF_Controller_Action {
    

    public function init(){
        
        parent::init();
        $authService = MF_Service_ServiceBroker::getInstance()->getService('User_Service_Auth');
        
        $user = $authService->getAuthenticatedUser();
        if($user->role=='agent'){
            
            $agentService = MF_Service_ServiceBroker::getInstance()->getService('Agent_Service_Agent');
            
            $branch = $agentService->getBranch($user['agent_id']);
            
            Zend_Layout::getMvcInstance()->assign('agent', $agent);
        }
        elseif($user->role=='branch'){
            
            $branchService = MF_Service_ServiceBroker::getInstance()->getService('Branch_Service_Branch');
            
            $branch = $branchService->getBranch($user['branch_id']);
            
            Zend_Layout::getMvcInstance()->assign('branch', $branch);
        }
    }
    
    public function indexAction()
    {
         $this->_helper->layout->setLayout('account');
         
        
        $authService = $this->_service->getService('User_Service_Auth');
        
        $user = $authService->getAuthenticatedUser();
        
        
        $this->view->assign('user',$user);
        
        if($user->role=='agent'){
        
            $rankingService = $this->_service->getService('Agent_Service_Ranking');

            $monthlyRankings = $rankingService->getAgentMonthlyRankings($this->_user['agent_id'],10);
            $this->view->assign('monthlyRankings',$monthlyRankings);
            $this->_helper->actionStack('sidebar');
        }
        elseif($user->role=='branch'){
            
            $this->_helper->viewRenderer('account/branch-index', null, true);
            $this->_helper->actionStack('sidebar');
        }
    }
    public function accountDataAction()
    {
         $this->_helper->layout->setLayout('account');
        $orderService = $this->_service->getService('Order_Service_Order');
        $authService = $this->_service->getService('User_Service_Auth');
        $userService = $this->_service->getService('User_Service_User');
        $modelCart = $orderService->getCart();
        $form = new Order_Form_PersonalData();
        $form->removeElement('difstreet');
        $form->removeElement('client_type');
        $form->removeElement('difpostal_code');
        $form->removeElement('difcity');
        $form->removeElement('difAddress');
        $form->removeElement('difflatNr');
        $form->removeElement('email');
        $form->removeElement('difhouseNr');
        $form->removeElement('submit');
        $ud = $userService->getFullUser(Zend_Auth::getInstance()->getIdentity(),'email');
        $user_id = $ud->getId();
        $userData = $userService->getProfile($user_id);
        $companyName = new Zend_Form_Element_Text('company_name');
        $companyName->setLabel('Company name');
        $companyName->setRequired(false);
        
        $submit = new Zend_Form_Element_Button('submit');
        $submit->setLabel('Save changes');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttrib('type', 'submit');
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));
        
        $form->addElement($companyName);
        $form->addElement($submit);
 //       Zend_Debug::dump($modelCart->getItems());
         if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    $user = $userService->saveClientFromArray($values,$user_id);
                    $this->_helper->redirector->gotoUrl($this->view->url(array('action'=> 'account-data'),'domain-account'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
             //   
         }}
        $this->view->assign('userData',$userData);
        $this->view->assign('form',$form);
    }
    public function sidebarAction()
    {
        
        $authService = $this->_service->getService('User_Service_Auth');
        
        $user = $authService->getAuthenticatedUser();
        
        $this->view->assign('user',$user);
        
       $this->_helper->viewRenderer->setResponseSegment('sidebar');
    }
    
    public function branchSidebarAction()
    {
        
        $authService = $this->_service->getService('User_Service_Auth');
        
        $user = $authService->getAuthenticatedUser();
        
        $this->view->assign('user',$user);
        
       $this->_helper->viewRenderer->setResponseSegment('sidebar');
    }
    
    public function listBranchAction()
    {
        $this->_helper->layout->setLayout('account');
         
         
        $authService = $this->_service->getService('User_Service_Auth');
        
        $user = $authService->getAuthenticatedUser();
        
        $this->view->assign('user',$user);
        
        if($user->role=='agent'){
            $branches = $user->get('Agent')->get('Branches');
            $this->view->assign('branches',$branches);
        }
        elseif($user->role=='branch'){

            $branches[] = $user->get('Branch');
            $this->view->assign('branches',$branches);
        }
        $this->_helper->actionStack('sidebar');
    }
    
    public function addBranchAction()
    {
        $this->_helper->layout->setLayout('account');
         
         
        $authService = $this->_service->getService('User_Service_Auth');
        
        $user = $authService->getAuthenticatedUser();
        
        $this->view->assign('user',$user);
        
        $branchService = $this->_service->getService('Branch_Service_Branch');


        $form = new Branch_Form_Branch();
        $form->getElement('agent_id')->setValue($user['agent_id']);
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    $data = $form->getValues();
                    unset($data['id']);
                    $branchService->saveBranchFromArray($data);

                    $this->_helper->getHelper('FlashMessenger')->setNamespace('success')->addMessage($this->view->translate('New branch has been successfully added.'));


                    $this->_helper->redirector->gotoUrl($this->view->url(array('action'=> 'list-branch'),'domain-account'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
             //   
            }
        }

        $this->view->assign('form',$form);
        $this->view->assign('branch',$branch);
        
        $this->_helper->actionStack('sidebar');
    }
    
    public function editBranchAction()
    {
        $this->_helper->layout->setLayout('account');
         
         
        $authService = $this->_service->getService('User_Service_Auth');
        
        $user = $authService->getAuthenticatedUser();
        
        $this->view->assign('user',$user);
        
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $hoursService = $this->_service->getService('Branch_Service_OpeningHours');

        if(!$branch = $branchService->getBranch($this->getRequest()->getParam('id'))){
            die('noBranch');
        }

        $form = new Branch_Form_Branch();
        
        $branchArray = $branch->toArray();
        $branchArray['description'] = $branch['Translation'][$this->view->language]['description'];
        
        $form->populate($branchArray);
        
        $hoursForm = new Branch_Form_OpeningHours();
        $hoursForm->populateForm($branch['OpeningHours']->toArray());
        $form->addSubForm($hoursForm,'hoursForm');

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    $data = $form->getValues();
                    
                    
                    $data['Translation']['pl']['description'] = $data['description'];
                    $data['Translation']['en']['description'] = $data['description'];
                    unset($data['id']);
                    $branch->fromArray($data);
//                        Zend_Debug::dump($branch->toArray());exit;
                    $branch->save();

                    $data['hoursForm']['branch_id'] = $branch['id'];
                    $hoursService->saveOpeningHoursFromArray($data['hoursForm']);
                    
                    $this->_helper->getHelper('FlashMessenger')->setNamespace('success')->addMessage($this->view->translate('Your branch has been successfully edited.'));


                    $this->_helper->redirector->gotoUrl($this->view->url(array('action'=> 'list-branch'),'domain-account'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
             //   
            }
        }

        $this->view->assign('form',$form);
        $this->view->assign('branch',$branch);
        
        $this->_helper->actionStack('sidebar');
    }
    
    public function deleteBranchAction()
    {
        $this->_helper->layout->setLayout('account');
         
         
        $authService = $this->_service->getService('User_Service_Auth');
        
        $user = $authService->getAuthenticatedUser();
        
        $this->view->assign('user',$user);
        
        $branchService = $this->_service->getService('Branch_Service_Branch');

        if(!$branch = $branchService->getBranch($this->getRequest()->getParam('id'))){
            die('noBranch');
        }

        $branch->delete();
        
        $this->_helper->getHelper('FlashMessenger')->setNamespace('success')->addMessage($this->view->translate('Your branch has been successfully edited.'));


                    $this->_helper->redirector->gotoUrl($this->view->url(array('action'=> 'list-branch'),'domain-account'));
              
        

        
        $this->_helper->actionStack('sidebar');
    }
    
     public function listStaffAction()
    {
        $this->_helper->layout->setLayout('account');
         
        $authService = $this->_service->getService('User_Service_Auth');
        
        $user = $authService->getAuthenticatedUser();
        
        $this->view->assign('user',$user);
        
        if($user->role=='agent'){
            $staffMembers = $user->get('Agent')->get('StaffMembers');
        }
        elseif($user->role=='branch'){
            $staffMembers = $user->get('Branch')->get('StaffMembers');
        }
        $this->view->assign('staffMembers',$staffMembers);
        $this->_helper->actionStack('sidebar');
    }
    
    public function editStaffAction()
    {
        $this->_helper->layout->setLayout('account');
         
        $authService = $this->_service->getService('User_Service_Auth');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $branchService = $this->_service->getService('Branch_Service_Branch');
        
        $user = $authService->getAuthenticatedUser();
        
        $this->view->assign('user',$user);
        
        
        if($this->getRequest()->getParam('id')){
            $staffService = $this->_service->getService('Staff_Service_Staff');
            
            if(!$staff = $staffService->getStaff($this->getRequest()->getParam('id'))){
                die('noStaff');
            }
            
            $form = new Staff_Form_Staff();
            $staffData = $staff->toArray();
            $staffData['description'] = $staff['Translation'][$this->view->language]['description'];
            $form->getElement('branch_id')->setMultiOptions($branchService->prependBranchesValues($user['agent_id']));
        
            $form->populate($staffData);
            
            if($this->getRequest()->isPost()) {
                if($form->isValid($this->getRequest()->getPost())) {
                    try {
                        $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                        $data = $form->getValues();
                        unset($data['id']);
                        
                        $data['Translation'][$this->view->language]['description'] = $data['description'];
                        $staff->fromArray($data);
                        $staff->save();
                        
                        if(isset($_POST['photoUrl'])){
                            $filePath = substr($_POST['photoUrl'],strrpos($_POST['photoUrl'],'/')+1);
//                            var_dump($filePath);exit;
                            $photo = $photoService->createPhotoFromTemp($filePath, $staff['firstname']." ".$staff['lastname'],$staff['firstname']." ".$staff['lastname'], array_keys(Staff_Model_Doctrine_Staff::getStaffPhotoDimensions()), false, false);
                 
                            $staff->set('PhotoRoot',$photo);
                            $staff->save();
                            
                            unlink(APPLICATION_PATH."/../public_html/media/photos/temp/".$filePath);
                            
                        }
                        
                        
                        $this->_helper->getHelper('FlashMessenger')->setNamespace('success')->addMessage($this->view->translate('Staff member has been successfully edited.'));
                   
                       $this->_service->get('doctrine')->getCurrentConnection()->commit();
                        
                        $this->_helper->redirector->gotoUrl($this->view->url(array('action'=> 'list-staff'),'domain-account'));
                    } catch(Exception $e) {
                        var_dump($e->getMessage());exit;
                        $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                        $this->_service->get('log')->log($e->getMessage(), 4);
                    }
                 //   
                }
            }
            
            $this->view->assign('form',$form);
            $this->view->assign('staff',$staff);
        }
        
        $this->_helper->actionStack('sidebar');
    }
    
   
    public function addStaffAction()
    {
        $this->_helper->layout->setLayout('account');
         
        $authService = $this->_service->getService('User_Service_Auth');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        $user = $authService->getAuthenticatedUser();
        
        $this->view->assign('user',$user);
        $staffService = $this->_service->getService('Staff_Service_Staff');

        $branchService = $this->_service->getService('Branch_Service_Branch');

        $form = new Staff_Form_Staff();
        if($user['role']=='agent'){
            $form->getElement('branch_id')->setMultiOptions($branchService->prependBranchesValues($user['agent_id']));
        }
        elseif($user['role']=='branch'){
            $form->getElement('branch_id')->setMultiOptions($branchService->prependBranchesValues($user['branch_id'],false,'branch'));
        }
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    $data = $form->getValues();
                    unset($data['id']);

                    $data['Translation'][$this->view->language]['description'] = $data['description'];
                    if($user['role']=='agent'){
                        $data['agent_id'] = $user['agent_id'];
                    }
                    elseif($user['role']=='branch'){
                        $data['agent_id'] = $user['Branch']['agent_id'];
                    }
                    $staff = $staffService->saveStaffFromArray($data,$this->view->language);

                    if(isset($_POST['photoUrl'])){
                        $filePath = substr($_POST['photoUrl'],strrpos($_POST['photoUrl'],'/')+1);
                        $photo = $photoService->createPhotoFromTemp($filePath, $staff['firstname']." ".$staff['lastname'],$staff['firstname']." ".$staff['lastname'], array_keys(Staff_Model_Doctrine_Staff::getStaffPhotoDimensions()), false, false);

                        $staff->set('PhotoRoot',$photo);
                        $staff->save();
                        
                        unlink(APPLICATION_PATH."/../public_html/media/photos/temp/".$filePath);

                    }


                    $this->_helper->getHelper('FlashMessenger')->setNamespace('success')->addMessage($this->view->translate('Staff member has been successfully edited.'));

                   $this->_service->get('doctrine')->getCurrentConnection()->commit();

                    $this->_helper->redirector->gotoUrl($this->view->url(array('action' => 'list-staff'),'domain-account'));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
             //   
            }
        }

        $this->view->assign('form',$form);
        
        $this->_helper->actionStack('sidebar');
    }
    
   public function deleteStaffAction()
    {
        $this->_helper->layout->setLayout('account');
         
        $authService = $this->_service->getService('User_Service_Auth');
        
        $user = $authService->getAuthenticatedUser();
        
        $this->view->assign('user',$user);
        
        $staffService = $this->_service->getService('Staff_Service_Staff');

        if(!$staff = $staffService->getStaff($this->getRequest()->getParam('id'))){
            die('noStaff');
        }

        $staff->delete();
        $this->_helper->redirector->gotoUrl($this->view->url(array('action'=> 'list-staff'),'domain-account'));
                   
    }
}

