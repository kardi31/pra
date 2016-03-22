<?php

/**
 * News_Service_News
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class News_Service_Guide extends MF_Service_ServiceAbstract{
    
    protected $guideTable;
    protected $categoryTable;
    
    public function init() {
        $this->guideTable = Doctrine_Core::getTable('News_Model_Doctrine_Guide');
        $this->categoryTable = Doctrine_Core::getTable('News_Model_Doctrine_GuideCategory');
    }
    
    
    public function getAllArticles($countOnly = false) {
        if(true == $countOnly) {
            return $this->newsTable->count();
        } else {
            return $this->newsTable->findAll();
        }
    }
    
    public function getCategory($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->categoryTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function getGuide($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->guideTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function getAllMainCategories($hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->categoryTable->createQuery('c');
        $q->addWhere('c.level = 0');
        return $q->execute(array(),$hydrationMode);
    }
    
    public function saveCategoryGuideFromArray($data) {
        foreach($data as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $data[$key] = NULL;
            }
        }
        if(!$category = $this->categoryTable->getProxy($data['id'])) {
            $category = $this->categoryTable->getRecord();
        }
        
        $category->fromArray($data);
        
        foreach($data['translations'] as $language => $translation) {
            $category->Translation[$language]->title = $translation['title'];
            $category->Translation[$language]->slug = MF_Text::createUniqueTableSlug('News_Model_Doctrine_GuideCategoryTranslation', $translation['title'], $category->getId());
            
        }
        
        $category->save();
        
        // if new category is added
        if(!isset($data['id'])){
            $category->set('root_id',$category['id']);
            $category->set('level',0);
            $category->set('lft',1);
            $category->set('rgt',2);
            $category->save();
        }
        
        return $category;
    }
    
    public function getFullGuide($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->guideTable->getGuideQuery();
        if(in_array($field, array('id'))) {
            $q->andWhere('g.' . $field . ' = ?', array($id));
        } elseif(in_array($field, array('slug'))) {
            $q->andWhere('gt.' . $field . ' = ?', array($id));
            $q->andWhere('gt.lang = ?', 'pl');
        }
        return $q->fetchOne(array(), $hydrationMode);
    }
    
    public function getFullCategory($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->categoryTable->createQuery('c');
        $q->leftJoin('c.Translation ct');
        if(in_array($field, array('id'))) {
            $q->andWhere('c.' . $field . ' = ?', array($id));
        } elseif(in_array($field, array('slug'))) {
            $q->andWhere('ct.' . $field . ' = ?', array($id));
            $q->andWhere('ct.lang = ?', 'pl');
        }
        $q->select('c.*,ct.*');
        return $q->fetchOne(array(), $hydrationMode);
    }
    public function getCategoryGuides($id, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->guideTable->getGuideQuery();
        $q->addWhere('g.category_id = ?',$id);
        return $q->execute(array(), $hydrationMode);
    }

    public function getMainCategories() {
        $q = $this->categoryTable->createQuery('c');
        $q->leftJoin('c.Translation ct');
        $q->addWhere('c.level = 0');
        $q->addOrderBy('ct.title');
        return $q->execute();
    }
    
    public function getCategoryPaginationQuery($category_id,$language) {
        $q = $this->newsTable->getNewsCategoryQuery();
       // $q = $this->newsTable->getPhotoQuery($q);
        $q->andWhere('nt.lang = ?', $language);
        $q->addWhere('c.id = ?',$category_id);
        $q->addOrderBy('n.publish_date DESC');
        
        return $q;
    }
    
    public function getVideoForm(Media_Model_Doctrine_VideoUrl $video = null) {
         
       
        $form = new News_Form_Video();
        
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
    
    public function getGuideCategoryItemForm(News_Model_Doctrine_GuideCategory $category = null) {
        $form = new News_Form_GuideCategory();
        if(null !== $category) {
            $categoryArray = $category->toArray();
            $form->populate($categoryArray);
        }
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            $i18nSubform = $form->translations->getSubForm($language);
            if($i18nSubform) {
                $i18nSubform->getElement('title')->setValue($category->Translation[$language]->title);
            }
        }
        return $form;
    }
    
    
    public function getGuideForm(News_Model_Doctrine_Guide $guide = null) {
         
       
        $form = new News_Form_Guide();
        $form->setDefault('publish', 1);
        
        if(null != $guide) {
            
            $form->populate($guide->toArray());
            if($publishDate = $guide->getPublishDate()) {
                $date = new Zend_Date($guide->getPublishDate(), 'yyyy-MM-dd HH:mm:ss');
                $form->getElement('publish_date')->setValue($date->toString('dd/MM/yyyy HH:mm'));
            }
            
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            $languages = $i18nService->getLanguageList();
            foreach($languages as $language) {
                $i18nSubform = $form->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('title')->setValue($guide->Translation[$language]->title);
                    $i18nSubform->getElement('content')->setValue($guide->Translation[$language]->content);
                }
            }
        }
        return $form;
    }
    
    
    public function prependCategoryOptions() {
       
       $options = array('' => '');
       $categories = $this->getMainCategories();
       
       foreach($categories as $category):
           foreach($category->getNode()->getChildren() as $subcategory):
                $options[$category['Translation']['pl']['title']][$subcategory['id']] = $subcategory['Translation']['pl']['title'];
           endforeach;
       endforeach;
       return $options;
    }
    
    public function saveGuideFromArray($values,$last_user_id,$user_id = null) {

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$guide = $this->guideTable->getProxy($values['id'])) {
            $guide = $this->guideTable->getRecord();
        }
       
        if($user_id!= null)
            $values['user_id'] = $user_id;
        
        $values['last_user_id'] = $last_user_id;
        
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        if(strlen($values['publish_date'])) {
            $date = new Zend_Date($values['publish_date'], 'dd/MM/yyyy HH:mm');
            $values['publish_date'] = $date->toString('yyyy-MM-dd HH:mm:00');
        } elseif(!strlen($guide['publish_date'])) {
            $values['publish_date'] = date('Y-m-d H:i:s');
        }

        $guide->fromArray($values);
 
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            if(is_array($values['translations'][$language]) && strlen($values['translations'][$language]['title'])) {
                $guide->Translation[$language]->title = $values['translations'][$language]['title'];
               
                $guide->Translation[$language]->slug = MF_Text::createUniqueTableSlug('News_Model_Doctrine_GuideTranslation', $values['translations'][$language]['title'], $guide->getId());
              
                $guide->Translation[$language]->content = $values['translations'][$language]['content'];
            }
        }
        
        $guide->save();
       
       
         
        return $guide;
    }
    
    public function moveCategory($category, $dest, $mode) {
        switch($mode) {
            case 'before':
                if($dest->getNode()->isRoot()) {
                    throw new Exception('Cannot move menu item on root level');
                }
                $category->getNode()->moveAsPrevSiblingOf($dest);
                break;
            case 'after':
                // if($dest->getNode()->isRoot()) {
                //     throw new Exception('Cannot move men item on root level');
                // }
                $category->getNode()->moveAsNextSiblingOf($dest);
                break;
            case 'over':
                $category->getNode()->moveAsLastChildOf($dest);
                break;
        }
    }
    
    public function removeNews(News_Model_Doctrine_News $news) {
        $news->delete();
    }
     
    public function removeCategory(News_Model_Doctrine_GuideCategory $category) {
        $category->Translation->delete();
        $category->delete();
    }
    public function searchNews($phrase, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->newsTable->getAllNewsQuery();
        $q->addSelect('TRIM(at.title) AS search_title, TRIM(at.content) as search_content, "news" as search_type');
        $q->andWhere('at.title LIKE ? OR at.content LIKE ?', array("%$phrase%", "%$phrase%"));
        return $q->execute(array(), $hydrationMode);
    }
    
      public function getLastNews($limit = 4, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->newsTable->getLastNewsQuery();
        $q->leftJoin('n.VideoRoot v');
        $q->addSelect('v.*');
        $q->orderBy('n.publish_date DESC');
        $q->limit($limit);
        return $q->execute(array(), $hydrationMode);
    }
    
     public function getBreakingNews($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->newsTable->getBreakingNewsQuery();
        $q->addWhere('n.breaking_news = 1');
        $q->orderBy('n.publish_date DESC');
        return $q->execute(array(), $hydrationMode);
    }
    
     public function getTargetNewsSelectOptions($prependEmptyValue = false, $language = null) {
        $items = $this->getAllNews();
        $result = array();
        if($prependEmptyValue) {
            $result[''] = ' ';
        }
        foreach($items as $item) {
                $result[$item->id] = $item->Translation[$language]->title;
        }
        return $result;
    } 
    
    
    public function getPopularNews($limit = 4, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->newsTable->getNewsCommentQuery();
//        $q->andWhere('n.publish = 1');
//        $q->addWhere('n.publish_date > NOW()');
        $q->addSelect('count(DISTINCT c.id) as comment_count');
        $q->addWhere('n.created_at > DATE_SUB(NOW(), INTERVAL 1 MONTH)');
        $q->orderBy('n.views DESC, comment_count DESC');
        $q->limit($limit);
        $q->groupBy('n.id');
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getLastCategoryOtherArticles($news, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->guideTable->getGuideQuery();
        $q->addWhere('g.category_id = ?',$news['category_id']);
        $q->addWhere('g.id != ?',$news['id']);
        $q->orderBy('g.publish_date DESC');
        $q->limit(8);
        return $q->execute(array(), $hydrationMode);
    }
    
     public function getLastCategoryNews($category_id,$limit = null, $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
        $q = $this->newsTable->getLastNewsQuery();
        $q->addWhere('n.category_id = ?',$category_id);
        $q->leftJoin('n.VideoRoot v');
        $q->addSelect('v.id');
        $q->orderBy('n.publish_date DESC');
        if($limit!=null){
            $q->limit($limit);
        }
        return $q->execute(array(), $hydrationMode);
    }
    
     public function getCategoryNews($id,$hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->newsTable->getNewsCategoryListQuery();
        $q->addWhere('c.id = ?',$id);
        $q->orderBy('n.publish_date DESC');
        return $q->execute(array(),$hydrationMode);
    }
    
    public function getGroupNews($id,$hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->newsTable->getNewsGroupListQuery();
        $q->addWhere('g.id = ?',$id);
        $q->orderBy('n.publish_date DESC');
        return $q->execute(array(),$hydrationMode);
    }
    
    public function getTagNews($id,$hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->newsTable->getNewsTagListQuery();
        $q->addWhere('t.id = ?',$id);
        $q->orderBy('n.publish_date DESC');
        return $q->execute(array(),$hydrationMode);
    }
    
    public function findNews($string, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->newsTable->getNewsTagListQuery();
        $q->where('nt.title like ?',"%".$string."%");
        $q->orWhere('nt.content like ?',"%".$string."%");
        $q->orWhere('t.title like ?',"%".$string."%");
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getStudentNews($hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->newsTable->getNewsStudentListQuery();
        $q->orderBy('n.publish_date DESC');
        return $q->execute(array(),$hydrationMode);
    }
    
    
}

