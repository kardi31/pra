<?php

/**
 * Advertisment_Service_Advertisment
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class Advertisment_Service_Advertisment extends MF_Service_ServiceAbstract{
    
    protected $advertismentTable;
    
    public function init() {
        $this->advertismentTable = Doctrine_Core::getTable('Advertisment_Model_Doctrine_Advertisment');
    }
    
    public function getAllAdvertisment($countOnly = false) {
        if(true == $countOnly) {
            return $this->advertismentTable->count();
        } else {
            return $this->advertismentTable->findAll();
        }
    }
    
    public function getAllArticles($countOnly = false) {
        if(true == $countOnly) {
            return $this->advertismentTable->count();
        } else {
            return $this->advertismentTable->findAll();
        }
    }
    
    public function getAdvertisment($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->advertismentTable->findOneBy($field, $id, $hydrationMode);
    }
  
    public function getAllNewStudentAdvertisment() {
        $q = $this->advertismentTable->getPublishAdvertismentQuery();
        $q->addWhere('n.student = 1');
        $q->addWhere('n.student_accept = 0');
        return $q->count();
    }
    
    public function getFullArticle($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->advertismentTable->getShowAdvertismentQuery();
        if(in_array($field, array('id'))) {
            $q->andWhere('n.' . $field . ' = ?', array($id));
        } elseif(in_array($field, array('slug'))) {
            $q->andWhere('nt.' . $field . ' = ?', array($id));
            $q->andWhere('nt.lang = ?', 'pl');
        }
        
        return $q->fetchOne(array(), $hydrationMode);
    }
    public function getArticleWithAd($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->advertismentTable->getAdvertismentQuery();
        if(in_array($field, array('id'))) {
            $q->andWhere('n.' . $field . ' = ?', array($id));
        } elseif(in_array($field, array('slug'))) {
            $q->andWhere('nt.' . $field . ' = ?', array($id));
            $q->andWhere('nt.lang = ?', 'pl');
        }
        $q->leftJoin('n.Videos v');
        $q->addSelect('v.*');
        $q->addSelect('a.*');
        $q->leftJoin('v.Ad a');
        $q->addWhere('a.publish = 1');
       $q->addWhere('a.date_from <= NOW()');
       $q->addWhere('a.date_to > NOW()');
        return $q->fetchOne(array(), $hydrationMode);
    }
    
   
    
    public function getNew($limit, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->advertismentTable->getPublishAdvertismentQuery();
        $q = $this->advertismentTable->getPhotoQuery($q);
        $q = $this->advertismentTable->getLimitQuery($limit, $q);
        $q->orderBy('a.created_at DESC');
        return $q->execute(array(), $hydrationMode);
    }

    public function getAdvertismentPaginationQuery($language) {
        $q = $this->advertismentTable->getPublishAdvertismentQuery();
       // $q = $this->advertismentTable->getPhotoQuery($q);
        $q->andWhere('at.lang = ?', $language);
        $q->addOrderBy('a.publish_date DESC');
        return $q;
    }
    
    public function getUserAdvertisments($user_id) {
        $q = $this->advertismentTable->createQuery('c');
        $q->leftJoin('c.Category ca');
        $q->leftJoin('c.Translation t');
        $q->leftJoin('c.PhotoRoot pr');
        $q->leftJoin('c.Photos ps');
        $q->select('c.*, p.*,ca.*,t.*,pr.*,ps.*');
        $q->where('c.user_id = ?',$user_id);
        $q->orderBy('c.created_at DESC');
        return $q->execute();
    }
    
    public function getCategoryPaginationQuery($category_id,$language) {
        $q = $this->advertismentTable->getAdvertismentCategoryQuery();
       // $q = $this->advertismentTable->getPhotoQuery($q);
        $q->andWhere('nt.lang = ?', $language);
        $q->addWhere('c.id = ?',$category_id);
        $q->addOrderBy('n.publish_date DESC');
        
        return $q;
    }
    
    
    public function getCategoryAdvertismentsQuery($category_id){
        $q = $this->advertismentTable->createQuery('c');
        $q->leftJoin('c.Category ca');
        $q->leftJoin('c.Translation t');
        $q->leftJoin('ca.Translation cat');
        $q->leftJoin('c.PhotoRoot pr');
        $q->leftJoin('c.Photos ps');
        $q->select('c.*, p.*,ca.*,t.*,pr.*,ps.*,cat.*');
        $q->where('ca.id = ?',$category_id);
        $q->orderBy('c.created_at DESC');
        return $q;
    }
    
    public function getVideoForm(Media_Model_Doctrine_VideoUrl $video = null) {
         
       
        $form = new Advertisment_Form_Video();
        
        if(null != $video) {
            
            $form->populate($video->toArray());
            
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            $languages = $i18nService->getLanguageList();
            foreach($languages as $language) {
                $i18nSubform = $form->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('name')->setValue($video->Translation[$language]->title);
                }
            }
        }
        return $form;
    }
    public function getAdvertismentForm(Advertisment_Model_Doctrine_Advertisment $advertisment = null) {
         
       
        $form = new Advertisment_Form_Advertisment();
        $form->setDefault('publish', 1);
        
        if(null != $advertisment) {
            $values = $advertisment->toArray();
            $values['title'] = $advertisment['Translation']['pl']['title'];
            $values['content'] = $advertisment['Translation']['pl']['content'];
            
            $form->populate($values);
            
//            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
//            $languages = $i18nService->getLanguageList();
//            foreach($languages as $language) {
//                $i18nSubform = $form->translations->getSubForm($language);
//                if($i18nSubform) {
//                    $i18nSubform->getElement('title')->setValue($advertisment->Translation[$language]->title);
//                    $i18nSubform->getElement('content')->setValue($advertisment->Translation[$language]->content);
//                }
//            }
        }
        return $form;
    }
    
    public function getAdvertismentAdminForm(Advertisment_Model_Doctrine_Advertisment $advertisment = null) {
         
       
        $form = new Advertisment_Form_AdvertismentAdmin();
        $form->setDefault('publish', 1);
        
        if(null != $advertisment) {
            
            $form->populate($advertisment->toArray());
            if($publishDate = $advertisment->get('finish_date')) {
                $date = new Zend_Date($advertisment->get('finish_date'), 'yyyy-MM-dd HH:mm:ss');
                $form->getElement('finish_date')->setValue($date->toString('dd/MM/yyyy HH:mm'));
            }
            
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            $languages = $i18nService->getLanguageList();
            foreach($languages as $language) {
                $i18nSubform = $form->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('title')->setValue($advertisment->Translation[$language]->title);
                    $i18nSubform->getElement('content')->setValue($advertisment->Translation[$language]->content);
                }
            }
        }
        return $form;
    }
    public function saveAdminAdvertismentFromArray($values,$last_user_id,$user_id = null) {

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$advertisment = $this->advertismentTable->getProxy($values['id'])) {
            $advertisment = $this->advertismentTable->getRecord();
        }
       
        if($user_id!= null)
            $values['user_id'] = $user_id;
        
        $values['last_user_id'] = $last_user_id;
        
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        if(strlen($values['finish_date'])) {
            $date = new Zend_Date($values['finish_date'], 'dd/MM/yyyy HH:mm');
            $values['finish_date'] = $date->toString('yyyy-MM-dd HH:mm:00');
        }

        
        $advertisment->fromArray($values);
 
        $language = 'pl';
        $advertisment->Translation[$language]->title = $values['title'];

        $advertisment->Translation[$language]->slug = MF_Text::createUniqueTableSlug('Advertisment_Model_Doctrine_AdvertismentTranslation', $values['title'], $advertisment->getId());

        $advertisment->Translation[$language]->content = $values['content'];
            
         $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            if(is_array($values['translations'][$language]) && strlen($values['translations'][$language]['title'])) {
                $advertisment->Translation[$language]->title = $values['translations'][$language]['title'];
               
                $advertisment->Translation[$language]->slug = MF_Text::createUniqueTableSlug('Advertisment_Model_Doctrine_AdvertismentTranslation', $values['translations'][$language]['title'], $advertisment->getId());
              
                $advertisment->Translation[$language]->content = $values['translations'][$language]['content'];
            }
        }
        
        $advertisment->save();
       
       
         
        return $advertisment;
    }
    public function saveAdvertismentFromArray($values) {

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$advertisment = $this->advertismentTable->getProxy($values['id'])) {
            $advertisment = $this->advertismentTable->getRecord();
        }
//       var_dump($advertisment);exit;
//        if($user_id!= null)
//            $values['user_id'] = $user_id;
//        
//        $values['last_user_id'] = $last_user_id;
        
//        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
//        
//        if(strlen($values['publish_date'])) {
//            $date = new Zend_Date($values['publish_date'], 'dd/MM/yyyy HH:mm');
//            $values['publish_date'] = $date->toString('yyyy-MM-dd HH:mm:00');
//        } elseif(!strlen($advertisment['publish_date'])) {
//            $values['publish_date'] = date('Y-m-d H:i:s');
//        }

        $wordFinishDate = str_replace('-',' ',$values['finish_date']);
        
        $values['finish_date'] = date('Y-m-d H:i:s',strtotime('+ '.$wordFinishDate));
        
        $advertisment->fromArray($values);
 
        $language = 'pl';
        $advertisment->Translation[$language]->title = $values['title'];

        $advertisment->Translation[$language]->slug = MF_Text::createUniqueTableSlug('Advertisment_Model_Doctrine_AdvertismentTranslation', $values['title'], $advertisment->getId());

        $advertisment->Translation[$language]->content = $values['content'];
            
        
//        $advertisment->unlink('Tags');
//        foreach($values['tag_id'] as $tag_id):
//            $advertisment->link('Tags',$tag_id);
//        endforeach;
        
        $advertisment->save();
       
       
         
        return $advertisment;
    }
    
    public function removeAdvertisment(Advertisment_Model_Doctrine_Advertisment $advertisment) {
        $advertisment->delete();
    }
     
    public function searchAdvertisment($phrase, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->advertismentTable->getAllAdvertismentQuery();
        $q->addSelect('TRIM(at.title) AS search_title, TRIM(at.content) as search_content, "advertisment" as search_type');
        $q->andWhere('at.title LIKE ? OR at.content LIKE ?', array("%$phrase%", "%$phrase%"));
        return $q->execute(array(), $hydrationMode);
    }
    
      public function getLastAdvertisment($limit = 4, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->advertismentTable->createQuery('a');
        $q->orderBy('a.created_at DESC');
        $q->limit($limit);
        return $q->execute(array(), $hydrationMode);
    }
    
      public function getLastCategoryAdvertisment($category_id,$limit = 4, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->advertismentTable->createQuery('a');
        $q->addWhere('a.category_id = ?',$category_id);
        $q->orderBy('a.created_at DESC');
        $q->limit($limit);
        return $q->execute(array(), $hydrationMode);
    }
    
     public function getBreakingAdvertisment($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->advertismentTable->getBreakingAdvertismentQuery();
        $q->addWhere('n.breaking_advertisment = 1');
        $q->orderBy('n.publish_date DESC');
        return $q->execute(array(), $hydrationMode);
    }
    
     public function getTargetAdvertismentSelectOptions($prependEmptyValue = false, $language = null) {
        $items = $this->getAllAdvertisment();
        $result = array();
        if($prependEmptyValue) {
            $result[''] = ' ';
        }
        foreach($items as $item) {
                $result[$item->id] = $item->Translation[$language]->title;
        }
        return $result;
    } 
    
    
    public function getPopularAdvertisment($limit = 4, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->advertismentTable->getAdvertismentCommentQuery();
//        $q->andWhere('n.publish = 1');
//        $q->addWhere('n.publish_date > NOW()');
        $q->addSelect('count(DISTINCT c.id) as comment_count');
        $q->addWhere('n.created_at > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
        $q->orderBy('n.views DESC, comment_count DESC');
        $q->limit($limit);
        $q->groupBy('n.id');
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getLastCategoryOtherArticles($advertisment, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->advertismentTable->getLastAdvertismentQuery();
        $q->addWhere('n.category_id = ?',$advertisment['category_id']);
        $q->addWhere('n.id != ?',$advertisment['id']);
        $q->leftJoin('n.VideoRoot v');
        $q->orderBy('n.publish_date DESC');
        $q->limit(8);
        return $q->execute(array(), $hydrationMode);
    }
    
    
     public function getCategoryAdvertisment($id,$hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->advertismentTable->getAdvertismentCategoryListQuery();
        $q->addWhere('c.id = ?',$id);
        $q->orderBy('n.publish_date DESC');
        return $q->execute(array(),$hydrationMode);
    }
    
    public function getGroupAdvertisment($id,$hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->advertismentTable->getAdvertismentGroupListQuery();
        $q->addWhere('g.id = ?',$id);
        $q->orderBy('n.publish_date DESC');
        return $q->execute(array(),$hydrationMode);
    }
    
    public function getTagAdvertisment($id,$hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->advertismentTable->getAdvertismentQuery();
        $q->addWhere('t.id = ?',$id);
        $q->orderBy('n.publish_date DESC');
        return $q->execute(array(),$hydrationMode);
    }
    
    public function findAdvertisment($search,$area, $language = 'pl',$hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->advertismentTable->getShowAdvertismentQuery();
        if(strlen($search)){
            $q->where('nt.title like ?',"%".$search."%");
        }
        if(strlen($area)){
            $q->andWhere('n.town like ? or n.street like ? or n.postcode like ?',array("%".$area."%","%".$area."%","%".$area."%"));
        }
        $q->addWhere('nt.lang = ?',$language);
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getStudentAdvertisment($hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->advertismentTable->getAdvertismentStudentListQuery();
        $q->orderBy('n.publish_date DESC');
        return $q->execute(array(),$hydrationMode);
    }
    
    
}

