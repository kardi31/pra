<?php

/**
 * Attraction_AdminController
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_AdminController extends MF_Controller_Action {
    
     protected $user;
        
    
     public function init() {
        $this->_helper->ajaxContext()
                ->initContext();
        parent::init();
        
        $authService = $this->_service->getService('User_Service_Auth');
        $this->user = $authService->getAuthenticatedUser();
    }
    
    public function listBranchAction() {
        
        
    }
    public function listBranchDataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $table = Doctrine_Core::getTable('Branch_Model_Doctrine_Branch');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Branch_DataTables_Branch', 
            'columns' => array('x.id','a.name','x.office_name','x.town','x.view','x.approved','x.premium_support', 'x.created_at','x.updated_at'),
            'searchFields' => array('x.id','a.name','x.office_name','x.town','x.view','x.approved','x.premium_support', 'x.created_at','x.updated_at')
        ));
        
        $results = $dataTables->getResult();
        $language = $i18nService->getAdminLanguage();

        $rows = array();
        foreach($results as $result) {
            
            $row = array();
            $row[] = $result->id;
            $row[] = $result['Agent']->name;
            $row[] = $result->office_name;
            $row[] = $result->town;
            
            if($result['view'] == 1){ 
                $row[] = '<a href="' . $this->view->adminUrl('toggle-branch', 'branch', array('id' => $result->id)) . '" title=""><span class="icon16 icomoon-icon-checkbox-2"></span></a>';
            }
            else{
                $row[] = '<a href="' . $this->view->adminUrl('toggle-branch', 'branch', array('id' => $result->id)) . '" title=""><span class="icon16 icomoon-icon-checkbox-unchecked-2"></span></a>';
            }
            
            if($result['approved'] == 1){ 
                $row[] = '<span class="icon16 icomoon-icon-checkbox-2"></span>';
            }
            else{
                $row[] = '<a href="' . $this->view->adminUrl('approve-branch', 'branch', array('id' => $result->id)) . '" title=""><span class="icon16 icomoon-icon-checkbox-unchecked-2"></span></a>';
            }
            
            
            if($result['premium_support'] == 1){ 
                $row[] = '<a href="' . $this->view->adminUrl('toggle-branch-premium', 'branch', array('id' => $result->id)) . '" title=""><span class="icon16 icomoon-icon-checkbox-2"></span></a>';
            }
            else{
                $row[] = '<a href="' . $this->view->adminUrl('toggle-branch-premium', 'branch', array('id' => $result->id)) . '" title=""><span class="icon16 icomoon-icon-checkbox-unchecked-2"></span></a>';
            }
            
            $row[] = $result['created_at'];
            $row[] = $result['updated_at'];
           
            
            $options = '<a href="' . $this->view->adminUrl('edit-branch', 'branch', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-branch', 'branch', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
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
    
    public function editBranchAction() {
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $authService = $this->_service->getService('User_Service_Auth');
        
        
        $user = $authService->getAuthenticatedUser();
        $translator = $this->_service->get('translate');
        
        if(!$branch = $branchService->getBranch($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Branch not found');
        }
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $branchService->getBranchAdminForm($branch);
                
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    
                    
                    $branch = $branchService->saveBranchAdminFromArray($values);
                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    

                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-branch', 'branch'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('branch', $branch);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function removeBranchAction() {
        $branchService = $this->_service->getService('Branch_Service_Branch');
        
        if(!$branch = $branchService->getBranch((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Banner not found');
        }
        
        $branch->delete();
        
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-branch', 'branch'));
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function toggleBranchAction() {
        $branchService = $this->_service->getService('Branch_Service_Branch');
        
        if(!$branch = $branchService->getBranch((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Banner not found');
        }
        
        if($branch['view']==1){
            $branch->set('view',0);
        }
        else{
            $branch->set('view',1);
        }
        $branch->save();
        
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-branch', 'branch'));
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function toggleBranchPremiumAction() {
        $branchService = $this->_service->getService('Branch_Service_Branch');
        
        if(!$branch = $branchService->getBranch((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Banner not found');
        }
        
        if($branch['premium_support']==1){
            $branch->set('premium_support',0);
        }
        else{
            $branch->set('premium_support',1);
        }
        $branch->save();
        
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-branch', 'branch'));
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function approveBranchAction() {
        $userService = $this->_service->getService('User_Service_User');
        $branchService = $this->_service->getService('Branch_Service_Branch');
        $mailService = $this->_service->getService('User_Service_Mail');
        
        if(!$branch = $branchService->getBranch((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Banner not found');
        }
        
        if($branch['approved']==1){
            $branch->set('view',0);
            $branch->set('approved',0);
        }
        else{
            $branch->set('view',1);
            $branch->set('approved',1);
            
            
            $passwordEncoder = new User_PasswordEncoder();
            $values['salt'] = MF_Text::createUniqueToken();
            $values['token'] = MF_Text::createUniqueToken();
            $values['role'] = 'branch';

            $values['email'] = $branch['email'];
            $values['branch_id'] = $branch['id'];

            $newPassword = MF_Text::createUniqueToken();

            $values['password'] = $passwordEncoder->encode($newPassword, $values['salt']);
            $user = $userService->saveUserFromArray($values);
            
            $options = $this->getFrontController()->getParam('bootstrap')->getOptions();
            $mail = new Zend_Mail('UTF-8');
            $mail->setSubject($this->view->translate('Your company account has been created on Rate Pole'));
            $mail->addTo($branch['email'], $branch['office_name']." ".$branch['office_name']);
            $mail->setReplyTo($options['reply_email'], 'Oceń Fachowca');
//                    $mail->addTo('kardi31@o2.pl');

            $mailService->sendBranchAddedMail($user,$branch,$newPassword,$mail, $this->view);
            
        }
        $branch->save();
        
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-branch', 'branch'));
        $this->_helper->viewRenderer->setNoRender();
    }
    public function listPeopleAction() {
        
        
    }
    public function listPeopleDataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $table = Doctrine_Core::getTable('District_Model_Doctrine_People');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'District_DataTables_People', 
            'columns' => array('x.id','xt.title', 'x.created_at','x.updated_at','x.publish_date'),
            'searchFields' => array('x.id','xt.title','x.created_at','x.updated_at','x.publish_date')
        ));
        
        $results = $dataTables->getResult();
        $language = $i18nService->getAdminLanguage();

        $rows = array();
        foreach($results as $result) {
            
            $row = array();
            $row[] = $result->id;
            $row[] = $result->Translation[$language->getId()]->title;
            $row[] = $result['created_at']. "<br />".$result['UserCreated']['last_name']. " ".$result['UserCreated']['first_name'];
            $row[] = $result['updated_at']. "<br /> ".$result['UserUpdated']['last_name']. " ".$result['UserUpdated']['first_name'];
           
            $row[] = MF_Text::timeFormat($result->publish_date, 'd/m/Y H:i');
            
            $options = '<a href="' . $this->view->adminUrl('edit-people', 'district', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-people', 'district', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
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
    
    public function addPeopleAction() {
        $peopleService = $this->_service->getService('District_Service_People');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
         $authService = $this->_service->getService('User_Service_Auth');
        
        
        $user = $authService->getAuthenticatedUser();
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $peopleService->getPeopleForm();
        $metatagsForm = $metatagService->getMetatagsSubForm();
        $form->addSubForm($metatagsForm, 'metatags');
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    if($metatags = $metatagService->saveMetatagsFromArray(null, $values, array('title' => 'title', 'description' => 'content', 'keywords' => 'content'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    $people = $peopleService->savePeopleFromArray($values,$user->getId(),$user->getId());
                    
                    $this->view->messages()->add($translator->translate('Item has been added'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-people', 'district', array('id' => $people->getId())));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function editPeopleAction() {
         $peopleService = $this->_service->getService('District_Service_People');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $videoService = $this->_service->getService('Media_Service_VideoUrl');
         $authService = $this->_service->getService('User_Service_Auth');
        
        
        $user = $authService->getAuthenticatedUser();
        $translator = $this->_service->get('translate');
        
        if(!$people = $peopleService->getPeople($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('People not found');
        }
        
        
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $peopleService->getPeopleForm($people);
        
        $metatagsForm = $metatagService->getMetatagsSubForm($people->get('Metatags'));
        $form->addSubForm($metatagsForm, 'metatags');
        
        if(!$people->photo_root_id){
            $photoRoot = $photoService->createPhotoRoot();
            $people->set('PhotoRoot',$photoRoot);
            $people->save();
        }
        
        if(!$people->video_root_id){
            $videoRoot = $videoService->createVideoRoot();
            $people->set('VideoRoot',$videoRoot);
            $people->save();
        }
        
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    
                    
                    if($metatags = $metatagService->saveMetatagsFromArray($people->get('Metatags'), $values, array('title' => 'title', 'description' => 'content', 'keywords' => 'content'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    
                    $people = $peopleService->savePeopleFromArray($values,$user->getId());
                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                     if(isset($_POST['add_video'])){
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('add-people-video', 'district',array('id' => $people->id)));
                    }
                    
                     if(isset($_POST['save_only'])){
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-people', 'district',array('id' => $people->id)));
                    }

                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-people', 'district'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('people', $people);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function removePeopleAction() {
        $peopleService = $this->_service->getService('District_Service_People');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagTranslationService = $this->_service->getService('Default_Service_MetatagTranslation');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
         $authService = $this->_service->getService('User_Service_Auth');
        
        
        $user = $authService->getAuthenticatedUser();
        if($people = $peopleService->getPeople($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                $metatag = $metatagService->getMetatag((int) $people->getMetatagId());
                $metatagTranslation = $metatagTranslationService->getMetatagTranslation((int) $people->getMetatagId());

                $photoRoot = $people->get('PhotoRoot');
                $photoService->removePhoto($photoRoot);
                
                $people->set('UserUpdated',$user);
                $people->save();
                
                $peopleService->removePeople($people);

                $metatagService->removeMetatag($metatag);
                $metatagTranslationService->removeMetatagTranslation($metatagTranslation);

                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-people', 'district'));
            } catch(Exception $e) {
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-people', 'district'));
    }
    
    public function addPeopleMainPhotoAction() {
        $peopleService = $this->_service->getService('District_Service_People');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$people = $peopleService->getPeople((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('People not found');
        }
        
        $options = $this->getInvokeArg('bootstrap')->getOptions();
        if(!array_key_exists('domain', $options)) {
            throw new Zend_Controller_Action_Exception('Domain string not set');
        }
        
        $href = $this->getRequest()->getParam('hrefs');

        if(is_string($href) && strlen($href)) {
            $path = str_replace("http://" . $options['domain'], "", urldecode($href));
            $filePath = urldecode($options['publicDir'] . $path);
            if(file_exists($filePath)) {
                $pathinfo = pathinfo($filePath);
                $slug = MF_Text::createSlug($pathinfo['basename']);
                $name = MF_Text::createUniqueFilename($slug, $photoService->photosDir);
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                    $root = $people->get('PhotoRoot');
                    
                     if(!$root || $root->isInProxyState()) {
                        $photo = $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(District_Model_Doctrine_People::getPeoplePhotoDimensions()), false, false);
                    } else {
                        $photo = $photoService->clearPhoto($root);       
                        $photo = $photoService->updatePhoto($root, $filePath, null, $name, $pathinfo['filename'], array_keys(District_Model_Doctrine_People::getPeoplePhotoDimensions()), false);                    
                    }
                    
                    $people->set('PhotoRoot', $photo);
                    $people->save();

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        
       
        $root = $people->get('PhotoRoot');
        $root->refresh();
        $list = $this->view->partial('admin/people-main-photo.phtml', 'district', array('photos' => $root, 'people' => $people));
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $people->getId()
        ));
        
    }
    public function removePeopleMainPhotoAction() {
        $peopleService = $this->_service->getService('District_Service_People');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$people = $peopleService->getPeople((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attraction not found');
        }
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
            if($root = $people->get('PhotoRoot')) {
                if($root && !$root->isInProxyState()) {
                    $photo = $photoService->updatePhoto($root);
                    $photo->setOffset(null);
                    $photo->setFilename(null);
                    $photo->setTitle(null);
                    $photo->save();
                }
            }
        
            $this->_service->get('doctrine')->getCurrentConnection()->commit();
        } catch(Exception $e) {
            $this->_service->get('doctrine')->getCurrentConnection()->rollback();
            $this->_service->get('log')->log($e->getMessage(), 4);
        }
        
        $root = $people->get('PhotoRoot');
        $list = $this->view->partial('admin/people-main-photo.phtml', 'news', array('photos' => $root , 'people' => $people));
        
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $people->getId()
        ));
        
    }
     public function addPeoplePhotoAction() {
        $peopleService = $this->_service->getService('District_Service_People');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$people = $peopleService->getPeople((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('People not found');
        }
        
        $options = $this->getInvokeArg('bootstrap')->getOptions();
        if(!array_key_exists('domain', $options)) {
            throw new Zend_Controller_Action_Exception('Domain string not set');
        }
        
        $hrefs = $this->getRequest()->getParam('hrefs');
     
        if(is_array($hrefs) && count($hrefs)) {
            foreach($hrefs as $href) {
                $path = str_replace("http://" . $options['domain'], "", urldecode($href));
                $filePath = $options['publicDir'] . $path;
                if(file_exists($filePath)) {
                    $pathinfo = pathinfo($filePath);
                    $slug = MF_Text::createSlug($pathinfo['basename']);
                    $name = MF_Text::createUniqueFilename($slug, $photoService->photosDir);
                    try {
                        $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                         $root = $people->get('PhotoRoot');

                       $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(District_Model_Doctrine_People::getPeoplePhotoDimensions()), $root, true);

                       $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    } catch(Exception $e) {
                        $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                        $this->_service->get('Logger')->log($e->getMessage(), 4);
                    }
                }
            }
        }

        
       
        $root = $people->get('PhotoRoot');
        $root->refresh();
        $photos = $photoService->getChildrenPhotos($root);
        $list = $this->view->partial('admin/people-photos.phtml', 'district', array('photos' => $photos, 'people' => $people));
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $people->getId()
        ));
        
    }
    
    public function editPeoplePhotoAction() {
        $peopleService = $this->_service->getService('District_Service_People');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$people = $peopleService->getPeople((int) $this->getRequest()->getParam('people-id'))) {
            throw new Zend_Controller_Action_Exception('People not found');
        }
        
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            $this->view->messages()->add($translator->translate('First you have to choose picture'), 'error');
            $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-people', 'district', array('id' => $people->getId())));
        }

        $form = $photoService->getPhotoForm($photo);
        $form->setAction($this->view->adminUrl('edit-people-photo', 'district', array('people-id' => $people->getId(), 'id' => $photo->getId())));
        
        $photosDir = $photoService->photosDir;
        $offsetDir = realpath($photosDir . DIRECTORY_SEPARATOR . $photo->getOffset());
        if(strlen($photo->getFilename()) > 0 && file_exists($offsetDir . DIRECTORY_SEPARATOR . $photo->getFilename())) {
            list($width, $height) = getimagesize($offsetDir . DIRECTORY_SEPARATOR . $photo->getFilename());
            $this->view->assign('imgDimensions', array('width' => $width, 'height' => $height));
        }
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    $photo = $photoService->saveFromArray($values);

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    if($this->getRequest()->getParam('saveOnly') == '1')
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-people-photo', 'district', array('id' => $people->getId(), 'photo' => $photo->getId())));
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-people', 'district', array('id' => $people->getId())));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('people', $people);
        $this->view->assign('photo', $photo);
        $this->view->assign('dimensions', District_Model_Doctrine_People::getPeoplePhotoDimensions());
        $this->view->assign('form', $form);
    }
    
    public function removePeoplePhotoAction() {
        $peopleService = $this->_service->getService('District_Service_People');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('photo-id'))) {
            throw new Zend_Controller_Action_Exception('Photo not found');
        }
        
        if(!$people = $peopleService->getPeople((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('People not found');
        }
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
            $photoService->removePhoto($photo);
        
            $this->_service->get('doctrine')->getCurrentConnection()->commit();
        } catch(Exception $e) {
            $this->_service->get('doctrine')->getCurrentConnection()->rollback();
            $this->_service->get('log')->log($e->getMessage(), 4);
        }
        
        $root = $people->get('PhotoRoot');
        $photos = $photoService->getChildrenPhotos($root);
        $list = $this->view->partial('admin/people-photos.phtml', 'district', array('photos' => $photos , 'people' => $people));
        
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $people->getId()
        ));
        
    }
     
    public function addPeopleVideoAction() {
        $peopleService = $this->_service->getService('District_Service_People');
        $videoService = $this->_service->getService('Media_Service_VideoUrl');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        if(!$people = $peopleService->getPeople((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('People not found');
        }
        $root = $people->get('VideoRoot');
        
        $form = new News_Form_Video();
       
        $this->view->assign('form',$form);
        
       
        $languages = $i18nService->getLanguageList();
        $adminLanguage = $i18nService->getAdminLanguage();
        $this->view->assign('languages', $languages);
        $this->view->assign('adminLanguage', $adminLanguage->getId());
        
        
         if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {                                   
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    $values = $form->getValues();  
                 
                    $video = $videoService->createVideoFromUpload($values, $root);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-people', 'district',array('id' => (int) $this->getRequest()->getParam('id'))));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
    }
    
     public function removePeopleVideoAction() {
        $videoService = $this->_service->getService('Media_Service_VideoUrl');
        $peopleService = $this->_service->getService('District_Service_People');
        
        
        if($video = $videoService->getVideo($this->getRequest()->getParam('id'))){
            try {
                
                $videoService->removeVideo($video);
                
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-people', 'district',array('id' => (int) $this->getRequest()->getParam('people-id'))));
         

            } catch(Exception $e) {
                var_dump($e->getMessage());exit;
               $this->_service->get('doctrine')->getCurrentConnection()->rollback();
               $this->_service->get('log')->log($e->getMessage(), 4);
            }

        }
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-people', 'district',array('id' => (int) $this->getRequest()->getParam('people-id'))));
         
        $this->_helper->viewRenderer->setNoRender();
               
    }
    
    public function movePeoplePhotoAction() {
        $photoService = $this->_service->getService('Media_Service_Photo');
        $peopleService = $this->_service->getService('District_Service_People');
        
        if(!$people = $peopleService->getPeople($this->getRequest()->getParam('people'))) {
            throw new Zend_Controller_Action_Exception('People not found');
        }
        
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('People photo not found');
        }

        $photoService->movePhoto($photo, $this->getRequest()->getParam('move', 'down'));
        
        $list = '';
        
        $root = $people->get('PhotoRoot');
        if(!$root->isInProxyState()) {
            $peoplePhotos = $photoService->getChildrenPhotos($root);
            $list = $this->view->partial('admin/people-photos.phtml', 'district', array('photos' => $peoplePhotos, 'people' => $people));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $people->getId()
        ));
    }
    
    public function listEventAction() {
        
        
    }
    public function listEventDataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $table = Doctrine_Core::getTable('District_Model_Doctrine_Event');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'District_DataTables_Event', 
            'columns' => array('x.id','xt.title', 'x.created_at','x.updated_at','x.publish_date'),
            'searchFields' => array('x.id','xt.title','x.created_at','x.updated_at','x.publish_date')
        ));
        
        $results = $dataTables->getResult();
        $language = $i18nService->getAdminLanguage();

        $rows = array();
        foreach($results as $result) {
            
            $row = array();
            $row[] = $result->id;
            $row[] = $result->Translation[$language->getId()]->title;
            $row[] = MF_Text::timeFormat($result['created_at'], 'd/m/Y H:i'). "<br />".$result['UserCreated']['last_name']. " ".$result['UserCreated']['first_name'];
            $row[] = MF_Text::timeFormat($result['updated_at'], 'd/m/Y H:i'). "<br /> ".$result['UserUpdated']['last_name']. " ".$result['UserUpdated']['first_name'];
           
            $row[] = MF_Text::timeFormat($result->publish_date, 'd/m/Y H:i');
            
            $options = '<a href="' . $this->view->adminUrl('edit-event', 'district', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-event', 'district', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
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
    
    public function addEventAction() {
        $eventService = $this->_service->getService('District_Service_Event');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $eventService->getEventForm();
        $form->removeElement('category_id');
        $form->removeElement('group_id');
        $form->getElement('publish_date')->setLabel('Data wydarzenia');
        $metatagsForm = $metatagService->getMetatagsSubForm();
        $form->addSubForm($metatagsForm, 'metatags');
        
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    if($metatags = $metatagService->saveMetatagsFromArray(null, $values, array('title' => 'title', 'description' => 'content', 'keywords' => 'content'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    $event = $eventService->saveEventFromArray($values,$this->user->getId(),$this->user->getId());
                    
                    if(!$event->photo_root_id){
                        $photoRoot = $photoService->createPhotoRoot();
                        $event->set('PhotoRoot',$photoRoot);
                        $event->save();
                    }
                    
//                    if($this->user['role']=="redaktor"):
//                        $event->set('student',1);
//                        $event->set('student_accept',0);
//                        $event->save();
//                    endif;
                    
                    $this->view->messages()->add($translator->translate('Item has been added'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-event', 'district'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function editEventAction() {
        $eventService = $this->_service->getService('District_Service_Event');
        $newsService = $this->_service->getService('News_Service_News');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $photoService = $this->_service->getService('Media_Service_Photo');
    //    $videoService = $this->_service->getService('Media_Service_VideoUrl');
       // $adService = $this->_service->getService('Banner_Service_Ad');
        
        
        $translator = $this->_service->get('translate');
        
        if(!$event = $eventService->getEvent($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Event not found');
        }
        
        
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $eventService->getEventForm($event);
        
        
        $form->removeElement('category_id');
        $form->removeElement('group_id');
        $form->getElement('publish_date')->setLabel('Data wydarzenia');
        
        $metatagsForm = $metatagService->getMetatagsSubForm($event->get('Metatags'));
        $form->addSubForm($metatagsForm, 'metatags');
//        if(!$event->photo_root_id){
//            $photoRoot = $photoService->createPhotoRoot();
//            $event->set('PhotoRoot',$photoRoot);
//            $event->save();
//        }
//        
//        if(!$event->video_root_id){
//            $videoRoot = $videoService->createVideoRoot();
//            $event->set('VideoRoot',$videoRoot);
//            $event->save();
//        }
//        if(!$video = $videoService->getVideo($event->video_root_id)) {
//            throw new Zend_Controller_Action_Exception('Video not found');
//        }
//        $videoForm = $newsService->getVideoForm($video);
//        $videoForm->getElement('ad_id')->addMultiOptions($adService->prependAds());
//        $videoForm->getElement('ad_id')->setValue($video->ad_id);
//        $videoForm->removeElement('date_from');
//        $videoForm->removeElement('date_to');
//        $this->view->assign('videoForm',$videoForm);
        
        
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) { // $videoForm->isValid($this->getRequest()->getParams())
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                //    $videoValues = $videoForm->getValues();
                //    $videoValues['id'] = $video['id'];
                    if($metatags = $metatagService->saveMetatagsFromArray($event->get('Metatags'), $values, array('title' => 'title', 'description' => 'content', 'keywords' => 'content'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    
                    $event = $eventService->saveEventFromArray($values,$this->user->getId());
                 //    $video = $videoService->createVideoFromUpload($videoValues, $videoRoot);
                    
                    
                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                   
                     if(isset($_POST['save_only'])){
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-event', 'district',array('id' => $event->id)));
                    }

                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-event', 'district'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('event', $event);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function removeEventAction() {
        $eventService = $this->_service->getService('District_Service_Event');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagTranslationService = $this->_service->getService('Default_Service_MetatagTranslation');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
         $authService = $this->_service->getService('User_Service_Auth');
        
        
        if($event = $eventService->getEvent($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                $metatag = $metatagService->getMetatag((int) $event->getMetatagId());
                $metatagTranslation = $metatagTranslationService->getMetatagTranslation((int) $event->getMetatagId());

                $photoRoot = $event->get('PhotoRoot');
                $photoService->removePhoto($photoRoot);
                
                $event->set('UserUpdated',$this->user);
                $event->save();
                
                $eventService->removeEvent($event);

                $metatagService->removeMetatag($metatag);
                $metatagTranslationService->removeMetatagTranslation($metatagTranslation);

                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-event', 'district'));
            } catch(Exception $e) {
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-event', 'district'));
    }
    
    public function addEventMainPhotoAction() {
        $eventService = $this->_service->getService('District_Service_Event');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$event = $eventService->getEvent((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Event not found');
        }
        
        $options = $this->getInvokeArg('bootstrap')->getOptions();
        if(!array_key_exists('domain', $options)) {
            throw new Zend_Controller_Action_Exception('Domain string not set');
        }
        
        $href = $this->getRequest()->getParam('hrefs');

        if(is_string($href) && strlen($href)) {
            $path = str_replace("http://" . $options['domain'], "", urldecode($href));
            $filePath = urldecode($options['publicDir'] . $path);
            if(file_exists($filePath)) {
                $pathinfo = pathinfo($filePath);
                $slug = MF_Text::createSlug($pathinfo['basename']);
                $name = MF_Text::createUniqueFilename($slug, $photoService->photosDir);
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                    $root = $event->get('PhotoRoot');
                    
                     if(!$root || $root->isInProxyState()) {
                        $photo = $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(District_Model_Doctrine_Event::getEventPhotoDimensions()), false, false);
                    } else {
                        $photo = $photoService->clearPhoto($root);       
                        $photo = $photoService->updatePhoto($root, $filePath, null, $name, $pathinfo['filename'], array_keys(District_Model_Doctrine_Event::getEventPhotoDimensions()), false);                    
                    }
                    
                    $event->set('PhotoRoot', $photo);
                    $event->save();

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        
       
        $root = $event->get('PhotoRoot');
        $root->refresh();
        $list = $this->view->partial('admin/event-main-photo.phtml', 'district', array('photos' => $root, 'event' => $event));
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $event->getId()
        ));
        
    }
    
    public function removeEventMainPhotoAction() {
        $eventService = $this->_service->getService('District_Service_Event');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$event = $eventService->getEvent((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Attraction not found');
        }
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
            if($root = $event->get('PhotoRoot')) {
                if($root && !$root->isInProxyState()) {
                    $photo = $photoService->updatePhoto($root);
                    $photo->setOffset(null);
                    $photo->setFilename(null);
                    $photo->setTitle(null);
                    $photo->save();
                }
            }
        
            $this->_service->get('doctrine')->getCurrentConnection()->commit();
        } catch(Exception $e) {
            $this->_service->get('doctrine')->getCurrentConnection()->rollback();
            $this->_service->get('log')->log($e->getMessage(), 4);
        }
        
        $root = $event->get('PhotoRoot');
        $list = $this->view->partial('admin/event-main-photo.phtml', 'district', array('photos' => $root , 'event' => $event));
        
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $event->getId()
        ));
        
    }
    
     public function addEventPhotoAction() {
        $eventService = $this->_service->getService('District_Service_Event');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$event = $eventService->getEvent((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Event not found');
        }
        
        $options = $this->getInvokeArg('bootstrap')->getOptions();
        if(!array_key_exists('domain', $options)) {
            throw new Zend_Controller_Action_Exception('Domain string not set');
        }
        
        $hrefs = $this->getRequest()->getParam('hrefs');
     
        if(is_array($hrefs) && count($hrefs)) {
            foreach($hrefs as $href) {
                $path = str_replace("http://" . $options['domain'], "", urldecode($href));
                $filePath = $options['publicDir'] . $path;
                if(file_exists($filePath)) {
                    $pathinfo = pathinfo($filePath);
                    $slug = MF_Text::createSlug($pathinfo['basename']);
                    $name = MF_Text::createUniqueFilename($slug, $photoService->photosDir);
                    try {
                        $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                         $root = $event->get('PhotoRoot');

                       $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(District_Model_Doctrine_Event::getEventPhotoDimensions()), $root, true);

                       $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    } catch(Exception $e) {
                        $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                        $this->_service->get('Logger')->log($e->getMessage(), 4);
                    }
                }
            }
        }

        
       
        $root = $event->get('PhotoRoot');
        $root->refresh();
        $photos = $photoService->getChildrenPhotos($root);
        $list = $this->view->partial('admin/event-photos.phtml', 'district', array('photos' => $photos, 'event' => $event));
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $event->getId()
        ));
        
    }
    
    public function editEventPhotoAction() {
        $eventService = $this->_service->getService('District_Service_Event');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$event = $eventService->getEvent((int) $this->getRequest()->getParam('event-id'))) {
            throw new Zend_Controller_Action_Exception('Event not found');
        }
        
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            $this->view->messages()->add($translator->translate('First you have to choose picture'), 'error');
            $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-event', 'district', array('id' => $event->getId())));
        }

        $form = $photoService->getPhotoForm($photo);
        $form->setAction($this->view->adminUrl('edit-event-photo', 'district', array('event-id' => $event->getId(), 'id' => $photo->getId())));
        
        $photosDir = $photoService->photosDir;
        $offsetDir = realpath($photosDir . DIRECTORY_SEPARATOR . $photo->getOffset());
        if(strlen($photo->getFilename()) > 0 && file_exists($offsetDir . DIRECTORY_SEPARATOR . $photo->getFilename())) {
            list($width, $height) = getimagesize($offsetDir . DIRECTORY_SEPARATOR . $photo->getFilename());
            $this->view->assign('imgDimensions', array('width' => $width, 'height' => $height));
        }
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    $photo = $photoService->saveFromArray($values);

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    if($this->getRequest()->getParam('saveOnly') == '1')
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-event-photo', 'district', array('id' => $event->getId(), 'photo' => $photo->getId())));
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-event', 'district', array('id' => $event->getId())));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('event', $event);
        $this->view->assign('photo', $photo);
        $this->view->assign('dimensions', District_Model_Doctrine_Event::getEventPhotoDimensions());
        $this->view->assign('form', $form);
    }
    
    public function removeEventPhotoAction() {
        $eventService = $this->_service->getService('District_Service_Event');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('photo-id'))) {
            throw new Zend_Controller_Action_Exception('Photo not found');
        }
        
        if(!$event = $eventService->getEvent((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Event not found');
        }
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
            $photoService->removePhoto($photo);
        
            $this->_service->get('doctrine')->getCurrentConnection()->commit();
        } catch(Exception $e) {
            $this->_service->get('doctrine')->getCurrentConnection()->rollback();
            $this->_service->get('log')->log($e->getMessage(), 4);
        }
        
        $root = $event->get('PhotoRoot');
        $photos = $photoService->getChildrenPhotos($root);
        $list = $this->view->partial('admin/event-photos.phtml', 'district', array('photos' => $photos , 'event' => $event));
        
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $event->getId()
        ));
        
    }
     
    public function addEventVideoAction() {
        $eventService = $this->_service->getService('District_Service_Event');
        $videoService = $this->_service->getService('Media_Service_VideoUrl');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        if(!$event = $eventService->getEvent((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Event not found');
        }
        $root = $event->get('VideoRoot');
        
        $form = new News_Form_Video();
       
        $this->view->assign('form',$form);
        
       
        $languages = $i18nService->getLanguageList();
        $adminLanguage = $i18nService->getAdminLanguage();
        $this->view->assign('languages', $languages);
        $this->view->assign('adminLanguage', $adminLanguage->getId());
        
        
         if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getPost())) {
                try {                                   
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    $values = $form->getValues();  
                 
                    $video = $videoService->createVideoFromUpload($values, $root);
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-event', 'district',array('id' => (int) $this->getRequest()->getParam('id'))));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
    }
    
     public function removeEventVideoAction() {
        $videoService = $this->_service->getService('Media_Service_VideoUrl');
        $eventService = $this->_service->getService('District_Service_Event');
        
        
        if($video = $videoService->getVideo($this->getRequest()->getParam('id'))){
            try {
                
                $videoService->removeVideo($video);
                
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-event', 'district',array('id' => (int) $this->getRequest()->getParam('event-id'))));
         

            } catch(Exception $e) {
                var_dump($e->getMessage());exit;
               $this->_service->get('doctrine')->getCurrentConnection()->rollback();
               $this->_service->get('log')->log($e->getMessage(), 4);
            }

        }
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-event', 'district',array('id' => (int) $this->getRequest()->getParam('event-id'))));
         
        $this->_helper->viewRenderer->setNoRender();
               
    }
    
    public function moveEventPhotoAction() {
        $photoService = $this->_service->getService('Media_Service_Photo');
        $eventService = $this->_service->getService('District_Service_Event');
        
        if(!$event = $eventService->getEvent($this->getRequest()->getParam('event'))) {
            throw new Zend_Controller_Action_Exception('Event not found');
        }
        
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Event photo not found');
        }

        $photoService->movePhoto($photo, $this->getRequest()->getParam('move', 'down'));
        
        $list = '';
        
        $root = $event->get('PhotoRoot');
        if(!$root->isInProxyState()) {
            $eventPhotos = $photoService->getChildrenPhotos($root);
            $list = $this->view->partial('admin/event-photos.phtml', 'district', array('photos' => $eventPhotos, 'event' => $event));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $event->getId()
        ));
    }
}

