<?php

/**
 * Attraction_AdminController
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Staff_AdminController extends MF_Controller_Action {
    
     protected $user;
        
    
     public function init() {
        $this->_helper->ajaxContext()
                ->initContext();
        parent::init();
        
        $authService = $this->_service->getService('User_Service_Auth');
        $this->user = $authService->getAuthenticatedUser();
    }
    
    public function listStaffAction() {
        
    }
    
    public function listStaffDataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $table = Doctrine_Core::getTable('Staff_Model_Doctrine_Staff');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Staff_DataTables_Staff',
            'columns' => array('x.id','x.firstname','x.lastname','a.name','x.rating','x.active_reviews','x.created_at','x.updated_at'),
            'searchFields' => array('x.id','x.firstname','x.lastname','a.name','x.rating','x.active_reviews','x.created_at','x.updated_at')
        ));
        
        $results = $dataTables->getResult();
        $language = $i18nService->getAdminLanguage();

        $rows = array();
        foreach($results as $result) {
            
            $row = array();
            $row[] = $result->id;
            $row[] = $result->firstname;
            if(strlen($result['link']))
                $row[] = '<a target="_blank" href="'.$this->view->url(array('slug' => $result['link']),'domain-staff-profile').'">'.$result->lastname.'</a>';
            else
                $row[] = $result->lastname;
            $row[] = $result['Agent']->name;
            $row[] = $result->rating;
            $row[] = $result->active_reviews;
           
            $row[] = $result['created_at'];
            $row[] = $result['updated_at'];
           
            
            $options = '<a href="' . $this->view->adminUrl('edit-staff', 'staff', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-staff', 'staff', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
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
    
    public function editStaffAction() {
        $staffService = $this->_service->getService('Staff_Service_Staff');
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $authService = $this->_service->getService('User_Service_Auth');
        
        
        $translator = $this->_service->get('translate');
        
        if(!$staff = $staffService->getStaff($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Staff not found');
        }
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $staffService->getStaffAdminForm($staff);
        
        
        $form->getElement('branch_id')->setMultiOptions($branchService->prependBranchesValues($staff['agent_id']));
        $form->getElement('branch_id')->setValue($staff['branch_id']);
                
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    
                    $staff = $staffService->saveStaffAdminFromArray($values);
                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    

                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-staff', 'staff'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('staff', $staff);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function removeStaffAction() {
        $staffService = $this->_service->getService('Staff_Service_Staff');
        
        if(!$staff = $staffService->getStaff((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Staff not found');
        }
        
        $staff->delete();
        
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-staff', 'staff'));
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function listUpdateAction() {
        
    }
    
    public function listUpdateDataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $table = Doctrine_Core::getTable('Staff_Model_Doctrine_Update');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Staff_DataTables_Update',
            'columns' => array('x.id','x.firstname','x.lastname','s.firstname','s.lastname','a.name','x.rating','x.active_reviews','x.created_at','x.updated_at'),
            'searchFields' => array('x.id','x.firstname','x.lastname','s.firstname','s.lastname','a.name','x.rating','x.active_reviews','x.created_at','x.updated_at')
        ));
        
        $results = $dataTables->getResult();
        $language = $i18nService->getAdminLanguage();

        $rows = array();
        foreach($results as $result) {
            
            $row = array();
            $row[] = $result->id;
            $row[] = $result->firstname;
            $row[] = $result->lastname;
            $row[] = $result['Staff']->firstname;
            if(strlen($result['Staff']['link']))
                $row[] = '<a target="_blank" href="'.$this->view->url(array('slug' => $result['Staff']['link']),'domain-staff-profile').'">'.$result['Staff']->lastname.'</a>';
            else
                $row[] = $result['Staff']->lastname;
            
            
            
            $row[] = $result['Staff']['Agent']->name;
            $row[] = $result['Staff']->rating;
            $row[] = $result['Staff']->active_reviews;
           
            $row[] = $result['created_at'];
            $row[] = $result['updated_at'];
           
            
            $options = '<a href="' . $this->view->adminUrl('edit-update', 'staff', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-update', 'staff', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
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
        $updateService = $this->_service->getService('Staff_Service_Update');
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        
        $translator = $this->_service->get('translate');
        
        if(!$update = $updateService->getUpdate($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Update not found');
        }
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $updateService->getUpdateAdminForm($update);
        
//        $form->getElement('branch_id')->setMultiOptions($branchService->prependBranchesValues($staff['agent_id']));
//        $form->getElement('branch_id')->setValue($staff['branch_id']);
                
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    
                    
                    $updateService->approveStaffUpdateFromArray($update,$values);
                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    

                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-update', 'staff'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('update', $update);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function removeUpdateAction() {
        $updateService = $this->_service->getService('Staff_Service_Update');
        
        if(!$update = $updateService->getUpdate((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Update not found');
        }
        
        $update->delete();
        
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-update', 'staff'));
        $this->_helper->viewRenderer->setNoRender();
    }
    
}

