<?php

/**
 * AdminController
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Default_AdminController extends MF_Controller_Action {

    public function init() {
        $this->view->assign('activeModule', 'settings');
        parent::init();
    }
    
    public function listLanguageAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');

        $form = $i18nService->getLanguageForm();
        $form->setAction($this->view->adminUrl('add-language', 'default'));
   
        $this->view->assign('form', $form);
    }

    public function listLanguageDataAction() {
        $table = Doctrine_Core::getTable('Default_Model_Doctrine_Language');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Default_DataTables_Language', 
            'columns' => array('x.name', 'x.id', 'x.active', 'x.default'),
            'searchFields' => array('x.name', 'x.id')
        ));
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row['DT_RowId'] = $result->id;
            $row[] = $result->name;
            $row[] = $result->id;
            $row[] = ($result->active) ? '<a href="javascript:void()" class="icon16 icomoon-icon-checkmark"></a>' : '';
            $row[] = ($result->default) ? '<a href="javascript:void()" class="icon16 icomoon-icon-checkmark"></a>' : '';
            $row[] = ($result->admin) ? '<a href="javascript:void()" class="icon16 icomoon-icon-checkmark"></a>' : '';
            $options ='<a href="' . $this->view->adminUrl('edit-language', 'default', array('id' => $result->id)) . '"><span class="icon16 entypo-icon-settings"></span></a>';
            $options .= '<a href="' . $this->view->adminUrl('delete-language', 'default', array('id' => $result->id)) . '"><span class="icon16 icomoon-icon-cancel-3"></span></a>';
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
    
    public function addLanguageAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
 
        $form = $i18nService->getLanguageForm();
   
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try{
                    $data = $form->getValues();
                    $i18nService->saveLanguageFromArray($data);
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-language', 'default'));
                } catch(Exception $e) {
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
                
            }
        }
        $this->view->assign('form', $form);
        
    }
    
    public function editLanguageAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        if(!$language = $i18nService->getLanguage($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Language not found');
        }
        
        $form = $i18nService->getLanguageForm($language);
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try{
                    $data = $form->getValues();
                    $i18nService->saveLanguageFromArray($data);
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-language', 'default'));
                } catch(Exception $e) {
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('language', $language);
        $this->view->assign('form', $form);
  
    }
    
    public function deleteLanguageAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $language = $i18nService->getLanguage($this->getRequest()->getParam('id'));
        if($language instanceof Default_Model_Doctrine_Language) {
            try {
                $i18nService->removeLanguage($language);
            } catch(Default_Model_LastLanguageDeleteException $e) {
                $this->view->messages()->add($e->getMessage(), 'error');
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            } catch(Exception $e) {
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }

        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-language', 'default'));
    }
    
    public function listSettingsAction() {
        $settingService = $this->_service->getService('Default_Service_Setting');
        
        $settings = $settingService->getAllAvailableSettings();

        $this->view->assign('settings', $settings);
    }
    
    public function editSettingsAction() {
        $settingService = $this->_service->getService('Default_Service_Setting');
        
        $form = $settingService->getSettingForm();
        $form->setAction($this->view->adminUrl('edit-settings', 'default'));

        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    $settingService->saveSettingsFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-settings', 'default'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $this->view->assign('form', $form);
    }

    public function listMetatagAction() {
        $this->view->assign('pages', array_intersect_key(Default_Model_Doctrine_Metatag::getAvailablePages(), Default_Model_Doctrine_Metatag::getAvailablePageMetatags()));
        
        $this->view->assign('activeActionPage', 'list-metatag');
    }
    
    public function editMetatagAction() {
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        $form = $metatagService->getPageMetatagsForm($this->getRequest()->getParam('page', 'home'));
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    $metatagService->savePageMetatagsFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    if($this->getRequest()->getParam('saveOnly') == '1')
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-metatag', 'default', array('page' => $this->getRequest()->getParam('page', 'home'))));
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-metatag', 'default'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
            
        $this->view->assign('form', $form);
        $this->view->assign('activeActionPage', 'list-metatag');
    }
     public function listContactAction() {
          $serviceService = $this->_service->getService('Default_Service_Service');
          $serviceData = $serviceService->getService(1);
          $this->view->assign('serviceData',$serviceData);
    }
    public function editContactAction() {
          $serviceService = $this->_service->getService('Default_Service_Service');
          $serviceData = $serviceService->getService(1);
          $form = $serviceService->getServiceForm($serviceData);
          if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    $serviceService->saveServiceFromArray($values);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-contact', 'default'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
          $this->view->assign('form',$form);
    }
    
    public function editPhotoAction(){
        $photoService = $this->_service->getService('Media_Service_Photo');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Photo photo not found');
        }

        $form = $photoService->getPhotoForm($photo);
        
        $type = $this->getRequest()->getParam('type');
        
        $elementId = $this->getRequest()->getParam('element-id');
        
        switch($type):
            case 'team':
                $class = 'League_Model_Doctrine_Team';
                $backUrl = $this->view->adminUrl('edit-team', 'league', array('id' => $elementId));
                break;
            case 'team-photo':
                $class = 'League_Model_Doctrine_Team';
                $dimensions = $class::getTeamPhotoDimensions();
                $backUrl = $this->view->adminUrl('edit-team', 'league', array('id' => $elementId));
                break;
            case 'page-main':
                $class = 'Page_Model_Doctrine_Page';
                $dimensions = $class::getPageMainPhotoDimensions();
                $backUrl = $this->view->adminUrl('edit-page', 'page', array('id' => $elementId));
                break;
            case 'page':
                $class = 'Page_Model_Doctrine_Page';
                $dimensions = $class::getPagePhotoDimensions();
                $backUrl = $this->view->adminUrl('edit-page', 'page', array('id' => $elementId));
                break;
            case 'player':
                $class = 'League_Model_Doctrine_Player';
                $backUrl = $this->view->adminUrl('edit-player', 'league', array('id' => $elementId));
                break;
            case 'gallery':
                $class = 'Gallery_Model_Doctrine_Gallery';
                $backUrl = $this->view->adminUrl('edit-gallery', 'gallery', array('id' => $elementId));
                break;
            case 'news':
                $class = 'News_Model_Doctrine_News';
                $backUrl = $this->view->adminUrl('edit-news', 'news', array('id' => $elementId));
                break;
            case 'coach':
                $class = 'League_Model_Doctrine_Coach';
                $backUrl = $this->view->adminUrl('edit-coach', 'league', array('id' => $elementId));
                break;
        endswitch;
        
        if(!isset($dimensions)){
            $dimensions = $class::getPhotoDimensions();
        }
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    $photo->set('title',$values['title']);
                    $photo->save();

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($backUrl);
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('dimensions', $dimensions);
        $this->view->assign('elementId', $elementId);
        $this->view->assign('backUrl', $backUrl);
        $this->view->assign('photo', $photo);
        $this->view->assign('form', $form);
    }
    
    public function listMessageAction() {

    }
    
    public function listMessageDataAction() {    
        $i18nService = $this->_service->getService('Default_Service_I18n');
       
        $table = Doctrine_Core::getTable('Default_Model_Doctrine_Message');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Default_DataTables_Message', 
            'columns' => array('x.id','x.name', 'x.email', 'x.town','x.address','x.postcode','s.id','x.created_at'),
            'searchFields' => array('x.id','x.name', 'x.email', 'x.town','x.address','x.postcode','s.id','x.created_at')
        ));
        
        $language = $i18nService->getAdminLanguage();
        
        $results = $dataTables->getResult();
        
        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row[] = $result->id;
            $row[] = $result->name;
            $row[] = $result->email;
            $row[] = $result->town;
            $row[] = $result->address;
            $row[] = $result->postcode;
            $row[] = count($result['Sends']);
            $row[] = MF_Text::timeFormat($result['created_at'],'d/m/Y H:i');
            $options = '<a href="' . $this->view->adminUrl('edit-message', 'default', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-message', 'default', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
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
    
    public function editMessageAction() {
        $messageService = $this->_service->getService('Default_Service_Message');
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $agentService = $this->_service->getService('Agent_Service_Agent');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $mailService = $this->_service->getService('User_Service_Mail');
        $translator = $this->_service->get('translate');
        
        if(!$message = $messageService->getMessage($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Message not found');
        }
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $messageService->getAdminMessageForm($message);
        $form->getElement('category')->addMultiOptions($agentService->prependMainCategories($this->view->language,false));
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    $values['id'] = $message['id'];
                    $message = $messageService->saveMessageFromArray($values);
                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    
                    if(isset($_POST['sendLeads'])){
                        
                        $options = $this->getFrontController()->getParam('bootstrap')->getOptions();
                        
                        foreach($_POST['branch_ids'] as $branchId){
                            
                            $branch = $branchService->getBranch($branchId);
                            
                            
                            $mail = new Zend_Mail('UTF-8');
                            $mail->setSubject($this->view->translate('You have new customer enquiry from Rate Pole'));
                            $mail->addTo($branch['email'], $branch['Agent']['name']." ".$branch['office_name']);
                            $mail->setReplyTo($values['email'], $values['name']);

                            $mailService->sendSpecialistContactMail($values,$branch,$mail, $this->view);
                            
                            $dataValues = array(
                                'message_id' => $message['id'],
                                'branch_id' => $branch['id']
                            );
                            
                            $messageService->saveMessageSendFromArray($dataValues);
                        }
                    }
                    
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    

                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-message', 'default'));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('message', $message);
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
    
}

