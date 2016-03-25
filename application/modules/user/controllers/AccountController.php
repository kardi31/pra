<?php

class User_AccountController extends MF_Controller_Action {
    
    protected $_user;

    public function init(){
        
        parent::init();
        $authService = MF_Service_ServiceBroker::getInstance()->getService('User_Service_Auth');
        
        $user = $authService->getAuthenticatedUser();
        $this->_user = $user;
        if($user->role=='agent'){
            
            $agentService = MF_Service_ServiceBroker::getInstance()->getService('Agent_Service_Agent');
            
            $agent = $agentService->getAgent($user['agent_id']);
            
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
            $agent = $user->get('Agent');
            $this->view->assign('branches',$branches);
            $this->view->assign('agent',$agent);
        }
        elseif($user->role=='branch'){

            $branches[] = $user->get('Branch');
            $this->view->assign('branches',$branches);
        }
        $this->_helper->actionStack('sidebar');
    }
    
    public function setHeadOfficeAction(){
        $branchService = $this->_service->getService('Branch_Service_Branch');

        if(!$branch = $branchService->getBranch($this->getRequest()->getParam('id'))){
            throw new Zend_Controller_Action_Exception('Branch not found');
        }
        
        if($this->user->role=='agent'){
            if($this->user->agent_id!=$branch['agent_id']){
                throw new Zend_Controller_Action_Exception('Hacking attempt');
            }
        }
        elseif($this->user->role=='branch'){
            if($this->user->branch_id!=$branch['id']){
                throw new Zend_Controller_Action_Exception('Hacking attempt');
            }
        }
        
        $agent = $branch->get('Agent');
        
        $agent->set('head_office_id',$branch['id']);
        $agent->save();
                    
        $this->_helper->redirector->gotoUrl($this->view->url(array('action'=> 'list-branch'),'domain-account'));
    }
    
    public function addBranchAction()
    {
        $this->_helper->layout->setLayout('account');
        
        $authService = $this->_service->getService('User_Service_Auth');
        $hoursService = $this->_service->getService('Branch_Service_OpeningHours');
        $branchService = $this->_service->getService('Branch_Service_Branch');
        
        $user = $authService->getAuthenticatedUser();
        
        $this->view->assign('user',$user);
        
        $form = new Branch_Form_Branch();
        $form->getElement('agent_id')->setValue($user['agent_id']);
        
        $hoursForm = new Branch_Form_OpeningHours();
        $form->addSubForm($hoursForm,'hoursForm');
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    $data = $form->getValues();
                    unset($data['id']);
                    $branch = $branchService->saveBranchFromArray($data);
                    
                    $data['hoursForm']['branch_id'] = $branch['id'];
                    $hoursService->saveOpeningHoursFromArray($data['hoursForm']);

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
                 
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $hoursService = $this->_service->getService('Branch_Service_OpeningHours');

        if(!$branch = $branchService->getBranch($this->getRequest()->getParam('id'))){
            throw new Zend_Controller_Action_Exception('Branch not found');
        }
        
        if($this->user->role=='agent'){
            if($this->user->agent_id!=$branch['agent_id']){
                throw new Zend_Controller_Action_Exception('Hacking attempt');
            }
        }
        elseif($this->user->role=='branch'){
            if($this->user->branch_id!=$branch['id']){
                throw new Zend_Controller_Action_Exception('Hacking attempt');
            }
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
                    
                    unset($data['id']);
                    $branch->fromArray($data);
                    
                    $branch->save();

                    $data['hoursForm']['branch_id'] = $branch['id'];
                    $hoursService->saveOpeningHoursFromArray($data['hoursForm']);
                    
                    $this->_helper->getHelper('FlashMessenger')->setNamespace('success')->addMessage($this->view->translate('Your branch has been successfully edited.'));


                    $this->_helper->redirector->gotoUrl($this->view->url(array('action'=> 'list-branch'),'domain-account'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $this->view->assign('form',$form);
        $this->view->assign('branch',$branch);
        
        $this->_helper->actionStack('sidebar');
    }
    
    public function deleteBranchAction()
    {
        $this->_helper->layout->setLayout('account');
         
        $branchService = $this->_service->getService('Branch_Service_Branch');

        if(!$branch = $branchService->getBranch($this->getRequest()->getParam('id'))){
            throw new Zend_Controller_Action_Exception('Branch not found');
        }

        if($this->user->role=='agent'){
            if($this->user->agent_id!=$branch['agent_id']){
                throw new Zend_Controller_Action_Exception('Hacking attempt');
            }
        }
        elseif($this->user->role=='branch'){
            if($this->user->branch_id!=$branch['id']){
                throw new Zend_Controller_Action_Exception('Hacking attempt');
            }
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
                    throw new Zend_Controller_Action_Exception('No staff member found');
            }
            
            
            if($this->user->role=='agent'){
                if($this->user->agent_id!=$staff['agent_id']){
                    throw new Zend_Controller_Action_Exception('Hacking attempt');
                }
            }
            elseif($this->user->role=='branch'){
                if($this->user->branch_id!=$staff['branch_id']){
                    throw new Zend_Controller_Action_Exception('Hacking attempt');
                }
            }
            
            $form = new Staff_Form_Staff();
            $staffData = $staff->toArray();
            $staffData['description'] = $staff['Translation'][$this->view->language]['description'];
            if($user['role']=='agent'){
                $form->getElement('branch_id')->setMultiOptions($branchService->prependBranchesValues($user['agent_id']));
            }
            elseif($user['role']=='branch'){
                $form->getElement('branch_id')->setMultiOptions($branchService->prependBranchesValues($user['branch_id'],false,'branch'));
            }
        
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
            throw new Zend_Controller_Action_Exception('No staff member found');
        }

        
        if($this->user->role=='agent'){
            if($this->user->agent_id!=$staff['agent_id']){
                throw new Zend_Controller_Action_Exception('Hacking attempt');
            }
        }
        elseif($this->user->role=='branch'){
            if($this->user->branch_id!=$staff['branch_id']){
                throw new Zend_Controller_Action_Exception('Hacking attempt');
            }
        }
        
        $staff->delete();
        $this->_helper->redirector->gotoUrl($this->view->url(array('action'=> 'list-staff'),'domain-account'));
                   
    }
    
    
    public function companyDetailsAction()
    {
        $this->_helper->layout->setLayout('account');
                 
        $agentService = $this->_service->getService('Agent_Service_Agent');

        if(!$agent = $agentService->getAgent($this->_user->agent_id)){
            throw new Zend_Controller_Action_Exception('Branch not found');
        }
        if($this->user->role=='branch'){
            throw new Zend_Controller_Action_Exception('Hacking attempt');
        }

        $form = new Branch_Form_Branch();
        $form->removeElement('address');
        $form->removeElement('office_name');
        $form->removeElement('email');
        $form->removeElement('town');
        $form->removeElement('county');
        $form->removeElement('postcode');
        
        $agentArray = $agent->toArray();
        $agentArray['description'] = $agent['Translation'][$this->view->language]['description'];
        
        $form->populate($agentArray);

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    $data = $form->getValues();
                    
                    unset($data['id']);
                    $agent->fromArray($data);
                    
                    $agent->save();
                    
                    $this->_helper->getHelper('FlashMessenger')->setNamespace('success')->addMessage($this->view->translate('Your company details has been successfully edited.'));

                   $this->_service->get('doctrine')->getCurrentConnection()->commit();

                    $this->_helper->redirector->gotoUrl($this->view->url(array('action'=> 'company-details'),'domain-account'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $this->view->assign('form',$form);
        $this->view->assign('agent',$agent);
        
        $this->_helper->actionStack('sidebar');
    }
    
    public function editPasswordAction()
    {
        $this->_helper->layout->setLayout('account');
        
        $form = new User_Form_UpdatePassword();
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    $data = $form->getValues();
                    
                    
                    $passwordEncoder = new User_PasswordEncoder();
                    $enteredPassword = $passwordEncoder->encode($data['old_password'], $this->_user['salt']);
                    
                    if($enteredPassword!=$this->_user['password']){
                        
                        $this->_helper->getHelper('FlashMessenger')->setNamespace('error')->addMessage($this->view->translate('Your current password is not correct.'));
                        $this->_helper->redirector->gotoUrl($this->view->url(array('action'=> 'edit-password'),'domain-account'));
                    }
                    
                    $salt = MF_Text::createUniqueToken();
                    $newPassword = $passwordEncoder->encode($data['password'], $salt);
                    
                    $this->_user->set('salt',$salt);
                    $this->_user->set('password',$newPassword);
                    $this->_user->save();
                    
                    $this->_helper->getHelper('FlashMessenger')->setNamespace('success')->addMessage($this->view->translate('Your password has been successfully edited.'));

                   $this->_service->get('doctrine')->getCurrentConnection()->commit();

                    $this->_helper->redirector->gotoUrl($this->view->url(array('action'=> 'edit-password'),'domain-account'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
            else{
                var_dump($form->getMessages());exit;
            }
        }
        
        $this->view->assign('form',$form);
        $this->_helper->actionStack('sidebar');
    }
}

