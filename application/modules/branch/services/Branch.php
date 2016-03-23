<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_Service_Branch extends MF_Service_ServiceAbstract {
    
    protected $branchTable;
    
    public function init() {
        $this->branchTable = Doctrine_Core::getTable('Branch_Model_Doctrine_Branch');
    }
      
    public function getBranch($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->branchTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllBranches(){
       return $this->branchTable->findAll();
   }
   
   
    public function saveNewBranchFromReview($agent_id,$branch_town){
        $values = array();
        
        
        $values['town'] = $branch_town;
        $values['office_name'] = $branch_town;
        $values['agent_id'] = $agent_id;
        $values['deleted_at'] = date('Y-m-d H:i:s');
        $values['view'] = 0;
        $values['approved'] = 0;
        $values['office_link'] = MF_Text::createUniqueTableField('Branch_Model_Doctrine_Branch','office_link', $branch_town);;
        
        $record = $this->branchTable->getRecord();
        $record->fromArray($values);
        $record->save();
        
        return $record;
    }
    
    public function saveNewAgentBranchFromReview($agent_id,$data){
        $values = array();
        
        
        $values['town'] = $data['town'];
        $values['office_name'] = $data['town'];
        $values['agent_id'] = $agent_id;
//        $values['deleted_at'] = date('Y-m-d H:i:s');
        $values['view'] = 0;
        $values['approved'] = 0;
        $values['office_link'] = MF_Text::createUniqueTableField('Branch_Model_Doctrine_Branch','office_link', $data['town']);;
        
        $record = $this->branchTable->getRecord();
        $record->fromArray($values);
        $record->save();
        
        return $record;
    }
    
    public function saveNewAgentBranchFromUpdate($agent_id,$data){
        $values = array();
        
        
        $values['town'] = $data['town'];
        $values['office_name'] = $data['town'];
        $values['agent_id'] = $agent_id;
//        $values['deleted_at'] = date('Y-m-d H:i:s');
        $values['view'] = 1;
        $values['approved'] = 1;
        $values['office_link'] = MF_Text::createUniqueTableField('Branch_Model_Doctrine_Branch','office_link', $data['town']);;
        
        $record = $this->branchTable->getRecord();
        $record->fromArray($values);
        $record->save();
        
        return $record;
    }
    
   public function getRandomPremiumBranches($limit = 6,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->branchTable->createQuery('b');
       $q->where('b.premium_support = 1');
       $q->addWhere('b.view = 1');
       $q->orderBy('rand()');
       $q->limit($limit);
       return $q->execute(array(),$hydrationMode);
   }
   
   public function getNotApprovedBranches($countOnly = false,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->branchTable->createQuery('b');
       $q->addWhere('b.approved = 0');
       $q->orderBy('b.created_at DESC');
       if($countOnly){
           return $q->count();
       }
       
       return $q->execute(array(),$hydrationMode);
   }
   
   public function getNewestBranches($limit = 6,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->branchTable->createQuery('b');
       $q->addWhere('b.view = 1');
       $q->orderBy('b.created_at DESC');
       $q->limit($limit);
       return $q->execute(array(),$hydrationMode);
   }
   
   public function getBestTownBranches($area,$limit = 6,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->branchTable->createQuery('b');
       $q->where('LOWER(town) like ?',array('%'.strtolower($area).'%'));
       $q->addWhere('b.view = 1');
       $q->orderBy('rating DESC');
       $q->limit($limit);
       return $q->execute(array(),$hydrationMode);
   }
   
   public function getAgentBranch($id, $field = 'id',$id2, $field2 = 'id'){
       $q = $this->branchTable->createQuery('b');
       $q->leftJoin('b.Agent a');
       $q->addWhere('b.'.$field2.' = ?',$id2);
       $q->addWhere('a.'.$field.' = ?',$id);
       return $q->fetchOne();
   }
   
   public function searchAgentBranches($agent_id,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->branchTable->createQuery('b');
       $q->addWhere('b.agent_id = ?',$agent_id);
       $q->orderBy('b.town DESC');
       return $q->execute(array(),$hydrationMode);
   }
   
   
   public function rankBranchesByTown($town,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->branchTable->createQuery('b');
       $q->addWhere('LOWER(b.town) like ?','%'.strtolower($town).'%');
       $q->orderBy('b.rating DESC');
       $q->limit(30);
       $q->leftJoin('b.Agent a');
       $q->leftJoin('a.Categories c');
       $q->leftJoin('c.Translation ct');
       $q->select('b.*,a.*,c.*,ct.*');
       return $q->execute(array(),$hydrationMode);
   }
   
   public function rankBranchesByCategory($category,$lang = 'pl', $hydrationMode = Doctrine_Core::HYDRATE_RECORD,$limit = 30){
       $q = $this->branchTable->createQuery('b');
       $q->addWhere('ct.slug = ? and ct.lang = ?',array($category,$lang));
       $q->orderBy('b.rating DESC');
       $q->limit($limit);
       $q->leftJoin('b.Agent a');
       $q->leftJoin('a.Categories c');
       $q->leftJoin('c.Translation ct');
       $q->select('b.*,a.*,c.*,ct.*');
       return $q->execute(array(),$hydrationMode);
   }
   
   public function rankBranchesByRegionAndCategory($region,$category,$lang = 'pl', $hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->branchTable->createQuery('b');
       $q->addWhere('LOWER(b.town) like ? or LOWER(b.county) like ? or LOWER(b.country) like ? or LOWER(b.postcode) like ?',array('%'.strtolower($region).'%','%'.strtolower($region).'%','%'.strtolower($region).'%',strtolower($town).'%'));
       $q->addWhere('ct.slug = ? and ct.lang = ?',array($category,$lang));
       $q->orderBy('b.rating DESC');
       $q->limit(40);
       $q->leftJoin('b.Agent a');
       $q->leftJoin('a.Categories c');
       $q->leftJoin('c.Translation ct');
       $q->select('b.*,a.*,c.*,ct.*');
       return $q->execute(array(),$hydrationMode);
   }
   
   public function searchAreaQuery($search,$searchName,$filters,$sort){
       $q = $this->branchTable->createQuery('b');
       if(strlen($search)){
            $q->addWhere('(LOWER(b.town) like ? OR LOWER(b.county) like ? OR LOWER(b.postcode) like ? OR LOWER(b.address) like ?)',array("%".strtolower($search)."%","%".strtolower($search)."%","%".strtolower($search)."%","%".strtolower($search)."%"));
       }
       if($searchName){
           
           $q->addWhere('a.name like "%'.strtolower($searchName).'%"');
       }
       if(isset($filters['category'])&&!empty($filters['category'])){
           
           $q->andWhereIn('c.id',$filters['category']);
       }
       
       if(isset($filters['rating'])){
           $q->andWhereIn('round(a.rating)',$filters['rating']);
       }
       
       $q->innerJoin('b.Agent a');
//       $q->leftJoin('a.PhotoRoot pr');
       $q->leftJoin('b.Translation bt');
       $q->leftJoin('a.Categories c');
       
       if(strlen($sort)){
            $sortArray = explode('_',$sort);
            if($sortArray[0]=='name'){
                $sortArray[0] = 'a.'.$sortArray[0];
            }
            $q->orderBy('b.premium_support DESC, '.$sortArray[0]." ".  strtoupper($sortArray[1]));
       }
       else{
           $q->orderBy('b.premium_support DESC,rating DESC');
       }
       
       $q->select('b.*,a.id,a.logo,a.name,a.link,bt.*');
//       echo $q;exit;
       return $q;
   }
   
    public function prependBranchesValues($agent_id,$prependEmptyValue = false,$type='agent'){
        if($type=='agent'){
            $branches = $this->searchAgentBranches($agent_id);
        }
        else{
            $branches[] = $this->getBranch($agent_id);
        }
       $options = array();
       
       if($prependEmptyValue){
           $options[''] = '';
       }
       
       foreach($branches as $branch){
           $options[$branch['id']] = $branch['town'].' - '.$branch['address'];
       }
       
       return $options;
       
   }
   
   public function searchAreaCount($search,$searchName,$filters,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->branchTable->createQuery('b');
       
       if(strlen($search)){
            $q->addWhere('(LOWER(b.town) like ? OR LOWER(b.county) like ? OR LOWER(b.postcode) like ? OR LOWER(b.address) like ?)',array("%".strtolower($search)."%","%".strtolower($search)."%","%".strtolower($search)."%","%".strtolower($search)."%"));
       }
       if($searchName){
           $q->addWhere('a.name like "%'.strtolower($searchName).'%"');
       }
      if(isset($filters['category'])&&!empty($filters['category'])){
           $q->andWhereIn('c.id',$filters['category']);
       }
       
       
       if(isset($filters['rating'])){
           $q->andWhereIn('round(a.rating)',$filters['rating']);
       }
       
       $q->select('a.*,b.*');
       $q->leftJoin('b.Agent a');
       $q->leftJoin('a.Categories c');
       $q->groupBy('b.id');
       
       return $q->count(array(),$hydrationMode);
   }
   
   
    public function getBranchAdminForm(Branch_Model_Doctrine_Branch $branch = null) {
        $form = new Branch_Form_BranchAdmin();
        
        if(null != $branch) {
            $bannerArray = $branch->toArray();
            $form->populate($bannerArray);
//            
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            $languages = $i18nService->getLanguageList();
            foreach($languages as $language) {
                $i18nSubform = $form->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('description')->setValue($branch->Translation[$language]->description);
                }
            }
        }   
        return $form;
    }
    
    public function saveBranchFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$branch = $this->branchTable->getProxy($values['id'])) {
            $branch = $this->branchTable->getRecord();
        }
        
        $branch->fromArray($values);
//        Zend_Debug::dump($branch->toArray());exit;
        $branch->save();
        
        return $branch;
    }
    
    public function saveBranchAdminFromArray($values) {
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$branch = $this->branchTable->getProxy($values['id'])) {
            $branch = $this->branchTable->getRecord();
        }
        
        $branch->fromArray($values);
         $languages = $i18nService->getLanguageList();
            $branch->office_link = MF_Text::createUniqueTableField('Branch_Model_Doctrine_Branch','office_link', $values['office_name'], $branch->get('id'));
        foreach($languages as $language) {
            if(is_array($values['translations'][$language]) && strlen($values['translations'][$language]['description'])) {                             
                $branch->Translation[$language]->description = $values['translations'][$language]['description'];
            }
        }
        
        $branch->save();
        
        return $branch;
    }
}

