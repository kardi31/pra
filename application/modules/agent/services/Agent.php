<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_Service_Agent extends MF_Service_ServiceAbstract {
    
    protected $agentTable;
    protected $categoryTable;
    
    public function init() {
        $this->agentTable = Doctrine_Core::getTable('Agent_Model_Doctrine_Agent');
        $this->categoryTable = Doctrine_Core::getTable('Agent_Model_Doctrine_Category');
    }
      
    public function getAgent($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->agentTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function getCategory($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->categoryTable->findOneBy($field, $id, $hydrationMode);
    }
    
    
    public function getFullCategory($id, $field = 'id',$lang = 'pl', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->categoryTable->createQuery('c');
        $q->leftJoin('c.Translation ct');
        $q->select('c.*,ct.*');
        if(in_array($field, array('id'))) {
            $q->andWhere('c.' . $field . ' = ?', array($id));
        } elseif(in_array($field, array('slug'))) {
            $q->andWhere('ct.' . $field . ' = ?', array($id));
            $q->andWhere('ct.lang = ?', $lang);
        }
        return $q->fetchOne(array(), $hydrationMode);
    }
    
    public function getRandomCategory(){
        $q = $this->categoryTable->createQuery('c');
        $q->leftJoin('c.Translation ct');
        $q->select('c.*,ct.*');
        $q->orderBy('rand()');
        $q->limit(1);
        return $q->fetchOne(array(), $hydrationMode);
    }
    
    
   public function getNotApprovedAgents($countOnly = false,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->agentTable->createQuery('b');
       $q->addWhere('b.approved = 0');
       $q->orderBy('b.created_at DESC');
       if($countOnly){
           return $q->count();
       }
       
       return $q->execute(array(),$hydrationMode);
   }
    
   public function getAllAgents(){
       return $this->agentTable->findAll();
   }
   public function getAgents($limit = 500,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->agentTable->createQuery('a');
       $q->limit($limit);
       return $q->execute(array(),$hydrationMode);
   }
   
   
   public function findAgents($query,$limit = 500,$language='pl',$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->agentTable->createQuery('a');
       $q->leftJoin('a.Categories c');
       $q->leftJoin('c.Translation ct');
       $q->select('a.name,a.rating,a.votes,a.logo,ct.title,c.id');
       $q->addWhere('LOWER(a.name) like ?',"%".strtolower($query)."%");
//       $q->addWhere('ct.lang = ?',$language);
       $q->limit($limit);
       return $q->execute(array(),$hydrationMode);
   }
   
   public function getRandomPremiumAgents($limit = 5,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->agentTable->createQuery('a');
       $q->where('a.premium_support = 1');
       $q->addWhere('a.view = 1');
       $q->orderBy('rand()');
       $q->limit($limit);
       return $q->execute(array(),$hydrationMode);
   }
   
   public function getMostPopularAgents($limit = 5,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->agentTable->createQuery('a');
       $q->where('a.premium_support = 1');
       $q->orderBy('a.views DESC');
       $q->limit($limit);
       return $q->execute(array(),$hydrationMode);
   }
   
   public function getActiveAd($id,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->agentTable->createQuery('p');
       $q->addWhere('p.id = ?',$id);
       $q->addWhere('p.publish = 1');
       $q->addWhere('p.date_from <= NOW()');
       $q->addWhere('p.date_to > NOW()');
       return $q->fetchOne(array(),$hydrationMode);
   }
   
   public function getCategoryTree(){
       return $this->categoryTable->getTree();
   }
   
   public function saveCategoryFromArray($values,$last_user_id,$user_id = null) {

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$category = $this->categoryTable->getProxy($values['id'])) {
            $category = $this->categoryTable->getRecord();
        }
       
        if($user_id!= null)
            $values['user_id'] = $user_id;
        
        $values['last_user_id'] = $last_user_id;
        
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        
        $category->fromArray($values);
 
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            if(is_array($values['translations'][$language]) && strlen($values['translations'][$language]['title'])) {
                $category->Translation[$language]->title = $values['translations'][$language]['title'];
               
                $category->Translation[$language]->slug = MF_Text::createUniqueTableSlug('Agent_Model_Doctrine_CategoryTranslation', $values['translations'][$language]['title'], $category->getId());
              
//                $category->Translation[$language]->content = $values['translations'][$language]['content'];
            }
        }
        
        $category->save();
       
       // if new category is added
        if(!isset($values['id'])){
            $category->set('root_id',$category['id']);
            $category->set('level',0);
            $category->set('lft',1);
            $category->set('rgt',2);
            $category->save();
        }
         
        return $category;
    }
    
    public function saveNewAgentFromReview($values) {

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        $values['view'] = 0;
        $values['approved'] = 0;
            
        $agent = $this->agentTable->getRecord();
       
        $values['link'] = MF_Text::createUniqueTableField('Agent_Model_Doctrine_Agent','link', $values['name']);;
       
        $agent->fromArray($values);
 
        $agent->save();
         
        return $agent;
    }
    
    public function getMainCategories($lang = 'pl') {
        $q = $this->categoryTable->createQuery('c');
        $q->select('c.*,ct.*');
        $q->leftJoin('c.Translation ct');
        $q->addWhere('c.level = 0');
        $q->addOrderBy('ct.title');
        $q->addWhere("ct.lang like '".$lang."'");
        return $q->execute();
    }
    
    public function prependMainCategories($language = 'pl',$slug = true){
        
        $categories = $this->getMainCategories($language);
        
        $result = array();
        foreach($categories as $mainCategory):
            foreach($mainCategory->getNode()->getChildren() as $subcategory){
                if($slug){
                    $result[$mainCategory['Translation'][$language]['title']][$subcategory['Translation'][$language]['slug']] = $subcategory['Translation'][$language]['title'];
                }
                else{
                    $result[$mainCategory['Translation'][$language]['title']][$subcategory['id']] = $subcategory['Translation'][$language]['title'];
                }
            }
        endforeach;
        
        return $result;
    }
  
    public function moveCategory($category, $dest, $mode) {
        switch($mode) {
            case 'before':
//                if($dest->getNode()->isRoot()) {
//                    throw new Exception('Cannot move menu item on root level');
//                }
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
   
   public function prependAds(){
       $ads = $this->getActiveAds(Doctrine_Core::HYDRATE_ARRAY);
       $adList = array();
       $adList[] = "";
       foreach($ads as $ad):
           $adList[$ad['id']] = $ad['Translation']['pl']['title'];
       endforeach;
       return $adList;
   }
   
   public function getActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->agentTable->createQuery('a');
       $q->leftJoin('a.Translation at');
       $q->addWhere('a.publish = 1');
//       $q->addWhere('a.date_from <= NOW()');
//       $q->addWhere('a.date_to > NOW()');
       return $q->execute(array(),$hydrationMode);
   }
   
   public function getAgentItemForm(News_Model_Doctrine_GuideCategory $category = null) {
        $form = new Agent_Form_Category();
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
    
    
    public function getAllMainCategories($hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->categoryTable->createQuery('c');
        $q->addWhere('c.level = 0');
        return $q->execute(array(),$hydrationMode);
    }
   
    
    public function saveAgentFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$agent = $this->agentTable->getProxy($values['id'])) {
            $agent = $this->agentTable->getRecord();
        }
        $agent->fromArray($values);
        $agent->save();
        
        return $agent;
    }
    
    public function getAgentAdminForm(Agent_Model_Doctrine_Agent $agent = null) {
        $form = new Agent_Form_AgentAdmin();
        
        if(null != $agent) {
            $bannerArray = $agent->toArray();
            $form->populate($bannerArray);
//            
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            $languages = $i18nService->getLanguageList();
            foreach($languages as $language) {
                $i18nSubform = $form->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('description')->setValue($agent->Translation[$language]->description);
                }
            }
        }   
        return $form;
    }
    
    public function saveAgentFromCms($values) {

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$agent = $this->agentTable->getProxy($values['id'])) {
            $agent = $this->agentTable->getRecord();
        }
        $values['link'] = MF_Text::createUniqueTableField('Agent_Model_Doctrine_Agent','link', $values['name'],$values['id']);;

        $agent->fromArray($values);
 
         $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
 
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            if(is_array($values['translations'][$language]) && strlen($values['translations'][$language]['description'])) {
                $agent->Translation[$language]->description = $values['translations'][$language]['description'];
              
            }
        }
        
        $agent->save();
         
        return $agent;
    }
    
    public function saveNewAgentFromUpdate($values) {

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        $values['view'] = 1;
        $values['approved'] = 1;
            
        $agent = $this->agentTable->getRecord();
//       die('299');
        $values['link'] = MF_Text::createUniqueTableField('Agent_Model_Doctrine_Agent','link', $values['name']);;

        $agent->fromArray($values);
 
         $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
 
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
            if(is_array($values['translations'][$language]) && strlen($values['translations'][$language]['description'])) {
                $agent->Translation[$language]->description = $values['translations'][$language]['description'];
              
            }
        }
        
        $agent->save();
         
        return $agent;
    }
    
   public function getAllAgentsOrder($order = 'id',$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->agentTable->createQuery('a');
       $q->orderBy('a.'.$order);
       return $q->execute(array(),$hydrationMode);
   }
    
    public function calculateAgentsRank(){
        $agents = $this->getAllAgentsOrder('points DESC');
        
        foreach($agents as $key => $agent){
            $agent->set('rank',($key+1));
            $agent->save();
        }
    }
    
}

