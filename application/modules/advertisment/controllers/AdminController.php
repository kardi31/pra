<?php

/**
 * Advertisment_AdminController
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class Advertisment_AdminController extends MF_Controller_Action {
    
    protected $user;
        
    
     public function init() {
        $this->_helper->ajaxContext()
                ->initContext();
        parent::init();
        
        $authService = $this->_service->getService('User_Service_Auth');
        $this->user = $authService->getAuthenticatedUser();
        $this->view->user = $this->user;
    }
    
    public function listAdvertismentAction() {}
    public function listAdvertismentDataAction() {
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $table = Doctrine_Core::getTable('Advertisment_Model_Doctrine_Advertisment');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Advertisment_DataTables_Advertisment', 
            'columns' => array('x.id','xt.title', 'c.title','g.title','x.created_at','x.updated_at','x.views','x.publish'),
            'searchFields' => array('x.id','xt.title','c.title','g.title','x.created_at','x.updated_at','x.views','x.publish')
        ));
        
        $results = $dataTables->getResult();
        $language = $i18nService->getAdminLanguage();

        $rows = array();
        foreach($results as $result) {
            
            $row = array();
            $row[] = $result->id;
            $row[] = $result->Translation[$language->getId()]->title;
            $row[] = $result['Category']['Translation'][$this->view->language]['title'];
            $row[] = strlen($result['Category']['Group']['Translation'][$this->view->language]['title'])?$result['Category']['Group']['Translation'][$this->view->language]['title']:"brak";
            
            $row[] = MF_Text::timeFormat($result['created_at'], 'd/m/Y H:i'). "<br />".$result['UserCreated']['last_name']. " ".$result['UserCreated']['first_name'];
            $row[] = MF_Text::timeFormat($result['updated_at'], 'd/m/Y H:i'). "<br /> ".$result['UserUpdated']['last_name']. " ".$result['UserUpdated']['first_name'];
           
            $row[] = MF_Text::timeFormat($result->finish_date, 'd/m/Y H:i');
            
            $row[] = $result->views;
            
             if($result['publish'] == 1){ 
                $row[] = '<a href="' . $this->view->adminUrl('set-advertisment-active', 'advertisment', array('id' => $result->id)) . '" title=""><span class="icon16 icomoon-icon-checkbox-2"><span class="spaninspan">Tak</span></span></a>';
            }
            else{
                $row[] = '<a href="' . $this->view->adminUrl('set-advertisment-active', 'advertisment', array('id' => $result->id)) . '" title=""><span class="icon16 icomoon-icon-checkbox-unchecked-2"><span class="spaninspan">Nie</span></span></a>';
            }
            
            $options = '<a href="' . $this->view->adminUrl('edit-advertisment', 'advertisment', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-advertisment', 'advertisment', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
            
            
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
    
    
    public function editAdvertismentAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $categoryService = $this->_service->getService('Advertisment_Service_Category');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        
        $translator = $this->_service->get('translate');
        
        if(!$advertisment = $advertismentService->getAdvertisment($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Advertisment not found');
        }
        
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $advertismentService->getAdvertismentAdminForm($advertisment);
        $form->getElement('category_id')->addMultiOptions($categoryService->prependCategoryOptions());
        $form->getElement('category_id')->setValue($advertisment['category_id']);
        
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    if($metatags = $metatagService->saveMetatagsFromArray($advertisment->get('Metatags'), $values, array('title' => 'title', 'description' => 'content', 'keywords' => 'content'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    
                    $advertisment = $advertismentService->saveAdminAdvertismentFromArray($values,$this->user->getId());
                    
                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    
                     
                     if(isset($_POST['save_only'])){
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-advertisment', 'advertisment',array('id' => $advertisment->id)));
                    }

                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-advertisment', 'advertisment'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('advertisment', $advertisment);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function removeAdvertismentAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $metatagTranslationService = $this->_service->getService('Default_Service_MetatagTranslation');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
         $authService = $this->_service->getService('User_Service_Auth');
        
        
        if($advertisment = $advertismentService->getAdvertisment($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                $metatag = $metatagService->getMetatag((int) $advertisment->get('metatag_id'));
                $metatagTranslation = $metatagTranslationService->getMetatagTranslation((int) $advertisment->get('metatag_id'));

                $photoRoot = $advertisment->get('PhotoRoot');
                $photoService->removePhoto($photoRoot);
                
                $advertisment->set('UserUpdated',$this->user);
                $advertisment->save();
                
                $advertisment->delete();

                $metatagService->removeMetatag($metatag);
//                $metatagTranslationService->removeMetatagTranslation($metatagTranslation);

                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-advertisment', 'advertisment'));
            } catch(Exception $e) {
                var_dump($e->getMessage());exit;
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-advertisment', 'advertisment'));
    }
    
    public function setAdvertismentActiveAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        
        if($advertisment = $advertismentService->getAdvertisment($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                if($advertisment->publish){
                    $advertisment->set('publish',0);
                }
                else{
                    $advertisment->set('publish',1);
                }
                    $advertisment->save();


                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-advertisment', 'advertisment'));
            } catch(Exception $e) {
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->viewRenderer->setNoRender();
    }
    
    public function setStudentAcceptAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        
        if($advertisment = $advertismentService->getAdvertisment($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                if($advertisment->student_accept){
                    $advertisment->set('student_accept',0);
                }
                else{
                    $advertisment->set('student_accept',1);
                }
                    $advertisment->save();


                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-advertisment', 'advertisment'));
            } catch(Exception $e) {
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->viewRenderer->setNoRender();
    }
    
   
    public function addAdvertismentMainPhotoAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $photoService = $this->_service->getService('Media_Service_Photo');
        if(!$advertisment = $advertismentService->getAdvertisment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Advertisment not found');
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

                    $root = $advertisment->get('PhotoRoot');
                    
                     if(!$root || $root->isInProxyState()) {
                        $photo = $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(Advertisment_Model_Doctrine_Advertisment::getAdvertismentPhotoDimensions()), false, false);
                    } else {
                        $photo = $photoService->clearPhoto($root);       
                        $photo = $photoService->updatePhoto($root, $filePath, null, $name, $pathinfo['filename'], array_keys(Advertisment_Model_Doctrine_Advertisment::getAdvertismentPhotoDimensions()), false);                    
                    }
                    
                    $advertisment->set('PhotoRoot', $photo);
                    $advertisment->save();

                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }

        
       
        $root = $advertisment->get('PhotoRoot');
        $root->refresh();
        $list = $this->view->partial('admin/advertisment-main-photo.phtml', 'advertisment', array('photos' => $root, 'advertisment' => $advertisment));
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $advertisment->getId()
        ));
        
    }
     public function addAdvertismentPhotoAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$advertisment = $advertismentService->getAdvertisment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Advertisment not found');
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

                         $root = $advertisment->get('PhotoRoot');

                       $photoService->createPhoto($filePath, $name, $pathinfo['filename'], array_keys(Advertisment_Model_Doctrine_Advertisment::getAdvertismentPhotoDimensions()), $root, true);

                       $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    } catch(Exception $e) {
                        $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                        $this->_service->get('Logger')->log($e->getMessage(), 4);
                    }
                }
            }
        }

        
       
        $root = $advertisment->get('PhotoRoot');
        $root->refresh();
        $photos = $photoService->getChildrenPhotos($root);
        $list = $this->view->partial('admin/advertisment-photos.phtml', 'advertisment', array('photos' => $photos, 'advertisment' => $advertisment));
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $advertisment->getId()
        ));
        
    }
    
    public function editAdvertismentPhotoAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $photoService = $this->_service->getService('Media_Service_Photo');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        if(!$advertisment = $advertismentService->getAdvertisment((int) $this->getRequest()->getParam('advertisment-id'))) {
            throw new Zend_Controller_Action_Exception('Advertisment not found');
        }
        
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            $this->view->messages()->add($translator->translate('First you have to choose picture'), 'error');
            $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-advertisment', 'advertisment', array('id' => $advertisment->getId())));
        }

        $form = $photoService->getPhotoForm($photo);
        $form->setAction($this->view->adminUrl('edit-advertisment-photo', 'advertisment', array('advertisment-id' => $advertisment->getId(), 'id' => $photo->getId())));
        
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
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-advertisment-photo', 'advertisment', array('id' => $advertisment->getId(), 'photo' => $photo->getId())));
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-advertisment', 'advertisment', array('id' => $advertisment->getId())));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('Logger')->log($e->getMessage(), 4);
                }
            }
        }
        
        $this->view->assign('advertisment', $advertisment);
        $this->view->assign('photo', $photo);
        $this->view->assign('dimensions', Advertisment_Model_Doctrine_Advertisment::getAdvertismentPhotoDimensions());
        $this->view->assign('form', $form);
    }
    
    public function removeAdvertismentPhotoAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('photo-id'))) {
            throw new Zend_Controller_Action_Exception('Photo not found');
        }
        
        if(!$advertisment = $advertismentService->getAdvertisment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Advertisment not found');
        }
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
            $photoService->removePhoto($photo);
        
            $this->_service->get('doctrine')->getCurrentConnection()->commit();
        } catch(Exception $e) {
            $this->_service->get('doctrine')->getCurrentConnection()->rollback();
            $this->_service->get('log')->log($e->getMessage(), 4);
        }
        
        $root = $advertisment->get('PhotoRoot');
        $photos = $photoService->getChildrenPhotos($root);
        $list = $this->view->partial('admin/advertisment-photos.phtml', 'advertisment', array('photos' => $photos , 'advertisment' => $advertisment));
        
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $advertisment->getId()
        ));
        
    }
    
    public function removeAdvertismentMainPhotoAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $photoService = $this->_service->getService('Media_Service_Photo');
        
        if(!$advertisment = $advertismentService->getAdvertisment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Advertisment not found');
        }
        
        try {
            $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
            if($root = $advertisment->get('PhotoRoot')) {
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
        
        $root = $advertisment->get('PhotoRoot');
        $list = $this->view->partial('admin/advertisment-main-photo.phtml', 'advertisment', array('photos' => $root , 'advertisment' => $advertisment));
        
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $advertisment->getId()
        ));
        
    }
    
     public function addVideoAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $adService = $this->_service->getService('Banner_Service_Ad');
        $videoService = $this->_service->getService('Media_Service_VideoUrl');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
        if(!$advertisment = $advertismentService->getAdvertisment((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Advertisment not found');
        }
        
        $root = $advertisment->get('VideoRoot');
        
        $form = new Advertisment_Form_Video();
        $form->getElement('ad_id')->addMultiOptions($adService->prependAds());
        $form->removeElement('date_from');
        $form->removeElement('date_to');
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
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-advertisment', 'advertisment',array('id' => (int) $this->getRequest()->getParam('id'))));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
    }
    
     public function editVideoAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $adService = $this->_service->getService('Banner_Service_Ad');
        $videoService = $this->_service->getService('Media_Service_VideoUrl');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        
         
        
        if(!$video = $videoService->getVideo((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Video not found');
        }
        
        
        $form = $advertismentService->getVideoForm($video);
        $form->getElement('ad_id')->addMultiOptions($adService->prependAds());
        $form->getElement('ad_id')->setValue($video->ad_id);
        $form->removeElement('date_from');
        $form->removeElement('date_to');
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
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-advertisment', 'advertisment',array('id' => (int) $this->getRequest()->getParam('advertisment-id'))));
                } catch(Exception $e) {
                    var_dump($e->getMessage());exit;
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }    
    }
    
     public function removeVideoAction() {
        $videoService = $this->_service->getService('Media_Service_VideoUrl');
        
        
        if($video = $videoService->getVideo($this->getRequest()->getParam('id'))){
            try {
                
                $videoService->removeVideo($video);
                
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-advertisment', 'advertisment',array('id' => (int) $this->getRequest()->getParam('advertisment-id'))));
         

            } catch(Exception $e) {
                var_dump($e->getMessage());exit;
               $this->_service->get('doctrine')->getCurrentConnection()->rollback();
               $this->_service->get('log')->log($e->getMessage(), 4);
            }

        }
        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-advertisment', 'advertisment',array('id' => (int) $this->getRequest()->getParam('advertisment-id'))));
         
        $this->_helper->viewRenderer->setNoRender();
               
    }
    
    public function moveAdvertismentPhotoAction() {
        $photoService = $this->_service->getService('Media_Service_Photo');
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        
        if(!$advertisment = $advertismentService->getAdvertisment($this->getRequest()->getParam('advertisment'))) {
            throw new Zend_Controller_Action_Exception('Advertisment not found');
        }
        
        if(!$photo = $photoService->getPhoto((int) $this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Advertisment photo not found');
        }

        $photoService->movePhoto($photo, $this->getRequest()->getParam('move', 'down'));
        
        $list = '';
        
        $root = $advertisment->get('PhotoRoot');
        if(!$root->isInProxyState()) {
            $advertismentPhotos = $photoService->getChildrenPhotos($root);
            $list = $this->view->partial('admin/advertisment-photos.phtml', 'advertisment', array('photos' => $advertismentPhotos, 'advertisment' => $advertisment));
        }
        
        $this->_helper->json(array(
            'status' => 'success',
            'body' => $list,
            'id' => $advertisment->getId()
        ));
    }
     public function listGroupAction() {}
    public function listGroupDataAction() {
        $table = Doctrine_Core::getTable('Advertisment_Model_Doctrine_CategoryGroup');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Advertisment_DataTables_CategoryGroup', 
            'columns' => array('x.id','x.title'),
            'searchFields' => array('x.id','x.title')
        ));
        
        $results = $dataTables->getResult();
        

        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row[] = $result->id;
            $row[] = $result->title;
           
            $options = '<a href="' . $this->view->adminUrl('edit-group', 'advertisment', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-group', 'advertisment', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
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
    
    public function addGroupAction() {
        $groupService = $this->_service->getService('Advertisment_Service_Group');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $groupService->getGroupForm();
        
        $metatagsForm = $metatagService->getMetatagsSubForm();
        $form->addSubForm($metatagsForm, 'metatags');
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    $metatagValues['translations']['pl'] = $values;
                    $metatagValues['metatags'] = $values['metatags']; 
                    if($metatags = $metatagService->saveMetatagsFromArray(null, $metatagValues, array('title' => 'title', 'description' => 'content', 'keywords' => 'content'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    $group = $groupService->saveGroupFromArray($values);
                    
                    $this->view->messages()->add($translator->translate('Item has been added'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-group', 'advertisment'));
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
    
    public function editGroupAction() {
        $groupService = $this->_service->getService('Advertisment_Service_Group');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $translator = $this->_service->get('translate');
        
        if(!$group = $groupService->getGroup($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Group not found');
        }
        
        $adminLanguage = $i18nService->getAdminLanguage();
        
        $form = $groupService->getGroupForm($group);
        
        $metatagsForm = $metatagService->getMetatagsSubForm($group->get('Metatags'));
        $form->addSubForm($metatagsForm, 'metatags');
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    
                    
                    
                    $metatagValues['translations']['pl'] = $values;
                    $metatagValues['metatags'] = $values['metatags']; 
                    if($metatags = $metatagService->saveMetatagsFromArray($group->get('Metatags'), $metatagValues, array('title' => 'title', 'description' => 'content', 'keywords' => 'content'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    
                    $group = $groupService->saveGroupFromArray($values);
                    $this->view->messages()->add($translator->translate('Item has been updated'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                   
                    
                     if(isset($_POST['save_only'])){
                        $this->_helper->redirector->gotoUrl($this->view->adminUrl('edit-group', 'advertisment',array('id' => $group->id)));
                    }

                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-group', 'advertisment'));
                } catch(Exception $e) {
                    $this->_service->get('doctrine')->getCurrentConnection()->rollback();
                    $this->_service->get('log')->log($e->getMessage(), 4);
                }
            }
        }
        $languages = $i18nService->getLanguageList();
        
        $this->view->assign('adminLanguage', $adminLanguage);
        $this->view->assign('advertisment', $advertisment);
        $this->view->assign('languages', $languages);
        $this->view->assign('form', $form);
    }
    
    public function removeGroupAction() {
        $groupService = $this->_service->getService('Advertisment_Service_Group');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        if($group = $groupService->getGroup($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                $metatag = $metatagService->getMetatag((int) $group->getMetatagId());

                $metatagService->removeMetatag($metatag);
                
                $group->delete();


                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-group', 'advertisment'));
            } catch(Exception $e) {
                var_dump($e->getMessage());exit;
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
        $this->_helper->viewRenderer->setNoRender();
    }
    
    
    /* tag - start */
    
    /* tag - end */
    
      public function listCategoryAction() {}
    public function listCategoryDataAction() {
        $table = Doctrine_Core::getTable('Advertisment_Model_Doctrine_Category');
        $dataTables = Default_DataTables_Factory::factory(array(
            'request' => $this->getRequest(), 
            'table' => $table, 
            'class' => 'Advertisment_DataTables_Category', 
            'columns' => array('x.id','x.title'),
            'searchFields' => array('x.id','x.title')
        ));
        
        $results = $dataTables->getResult();
        

        $rows = array();
        foreach($results as $result) {
            $row = array();
            $row[] = $result->id;
            $row[] = $result->title;
            $row[] = $result['Group']->title;
           
            $options = '<a href="' . $this->view->adminUrl('edit-category', 'advertisment', array('id' => $result->id)) . '" title="' . $this->view->translate('Edit') . '"><span class="icon24 entypo-icon-settings"></span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $options .= '<a href="' . $this->view->adminUrl('remove-category', 'advertisment', array('id' => $result->id)) . '" class="remove" title="' . $this->view->translate('Remove') . '"><span class="icon16 icon-remove"></span></a>';
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
    
    public function addCategoryAction() {
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $categoryService = $this->_service->getService('Advertisment_Service_Category');
        $groupService = $this->_service->getService('Advertisment_Service_Group');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $translator = $this->_service->get('translate');
        
        $adminLanguage = $i18nService->getAdminLanguage();
        $form = $categoryService->getCategoryForm();
        $form->getElement('group_id')->addMultiOptions($groupService->prependGroupOptions());
        
        
        $metatagsForm = $metatagService->getMetatagsSubForm();
        $form->addSubForm($metatagsForm, 'metatags');
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    $metatagValues['translations']['pl'] = $values;
                    $metatagValues['metatags'] = $values['metatags']; 
                    if($metatags = $metatagService->saveMetatagsFromArray(null, $metatagValues, array('title' => 'title', 'description' => 'content', 'keywords' => 'content'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    $group = $categoryService->saveCategoryFromArray($values);
                    
                    $this->view->messages()->add($translator->translate('Item has been added'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-category', 'advertisment'));
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
    
    public function editCategoryAction() {
        
        $advertismentService = $this->_service->getService('Advertisment_Service_Advertisment');
        $categoryService = $this->_service->getService('Advertisment_Service_Category');
        $groupService = $this->_service->getService('Advertisment_Service_Group');
        $i18nService = $this->_service->getService('Default_Service_I18n');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        $translator = $this->_service->get('translate');
        
        if(!$category = $categoryService->getCategory($this->getRequest()->getParam('id'))) {
            throw new Zend_Controller_Action_Exception('Category not found');
        }
        
       
        $adminLanguage = $i18nService->getAdminLanguage();
        $form = $categoryService->getCategoryForm($category);
        $form->getElement('group_id')->addMultiOptions($groupService->prependGroupOptions());
        $form->getElement('group_id')->setValue($category['group_id']);
        
        $metatagsForm = $metatagService->getMetatagsSubForm();
        $form->addSubForm($metatagsForm, 'metatags');
        
        if($this->getRequest()->isPost()) {
            if($form->isValid($this->getRequest()->getParams())) {
                try {
                    $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();
                    
                    $values = $form->getValues();
                    $metatagValues['translations']['pl'] = $values;
                    $metatagValues['metatags'] = $values['metatags']; 
                    if($metatags = $metatagService->saveMetatagsFromArray(null, $metatagValues, array('title' => 'title', 'description' => 'content', 'keywords' => 'content'))) {
                        $values['metatag_id'] = $metatags->getId();
                    }
                    $group = $categoryService->saveCategoryFromArray($values);
                    
                    $this->view->messages()->add($translator->translate('Item has been added'), 'success');
                    
                    $this->_service->get('doctrine')->getCurrentConnection()->commit();
                    
                    $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-category', 'advertisment'));
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
        $this->view->assign('category', $category);
        
        
    }
    
    public function removeCategoryAction() {
        $categoryService = $this->_service->getService('Advertisment_Service_Category');
        $metatagService = $this->_service->getService('Default_Service_Metatag');
        
        if($category = $categoryService->getCategory($this->getRequest()->getParam('id'))) {
            try {
                $this->_service->get('doctrine')->getCurrentConnection()->beginTransaction();

                $metatag = $metatagService->getMetatag((int) $category->getMetatagId());

                $metatagService->removeMetatag($metatag);
                
                $category->delete();


                $this->_service->get('doctrine')->getCurrentConnection()->commit();
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-category', 'advertisment'));
            } catch(Exception $e) {
                var_dump($e->getMessage());exit;
                $this->_service->get('Logger')->log($e->getMessage(), 4);
            }
        }
                $this->_helper->redirector->gotoUrl($this->view->adminUrl('list-category', 'advertisment'));
        $this->_helper->viewRenderer->setNoRender();
    }
}

