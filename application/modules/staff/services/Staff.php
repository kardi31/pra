<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Staff_Service_Staff extends MF_Service_ServiceAbstract {
    
    protected $staffTable;
    
    public function init() {
        $this->staffTable = Doctrine_Core::getTable('Staff_Model_Doctrine_Staff');
    }
      
    public function getStaff($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->staffTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllStaffs(){
       return $this->staffTable->findAll();
   }
   
    public function saveStaffFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->staffTable->getProxy($values['id'])) {
            $record = $this->staffTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
    public function saveNewStaffFromReview($staffName,$agent_id,$branch_id){
        
        
        $values = array();
        
        $staffNameExpl = explode(' ',$staffName,1);
        
        $values['firstname'] = $staffNameExpl[0];
        $values['lastname'] = $staffNameExpl[1];
        $values['agent_id'] = $agent_id;
        $values['branch_id'] = strlen($branch_id)?$branch_id:null;
        $values['approved'] = 0;
        $values['view'] = 0;
        $record = $this->staffTable->getRecord();
        $record->fromArray($values);
        $record->save();
        
        return $record;
    }
    
    
   public function findStaff($params,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->staffTable->createQuery('s');
       $q->select('s.*');
        if(isset($params['branch'])&&$params['branch']){
            $q->addWhere('s.branch_id = ?',$params['branch']);
        }
       
        if(isset($params['agent'])){
            $q->addWhere('s.agent_id = ?',$params['agent']);
        }
        
        if(isset($params['query'])){
            $explode = explode(' ',$params['query'],2);
            
            if(count($explode)>0){
                $q->andWhere('(s.firstname like ? and s.lastname like ?) or (s.firstname like ? and s.lastname like ?)',array('%'.$explode[0].'%','%'.$explode[1].'%','%'.$explode[1].'%','%'.$explode[0].'%'));
            }
            else{
                $q->andWhere('(s.firstname like ? or s.lastname like ?)',array('%'.$explode[0].'%','%'.$explode[0].'%'));
            }
            
        }
        
        if(isset($params['id'])){
            $q->addWhere('s.id = ?',$params['id']);
        }
       $q->orderBy('s.rating DESC');
       return $q->execute(array(),$hydrationMode);
   }
   
   public function searchStaffQuery($staff_name,$agent_name,$filters,$sort){
       $q = $this->staffTable->createQuery('s');
       
       
        if(strlen($staff_name)){
            $explode = explode(' ',$staff_name,2);
            
            if(count($explode)>0){
                $q->andWhere('(s.firstname like ? and s.lastname like ?) or (s.firstname like ? and s.lastname like ?)',array('%'.$explode[0].'%','%'.$explode[1].'%','%'.$explode[1].'%','%'.$explode[0].'%'));
            }
            else{
                $q->andWhere('(s.firstname like ? or s.lastname like ?)',array('%'.$explode[0].'%','%'.$explode[0].'%'));
            }
        }
        
        if(strlen($agent_name)){
            $q->addWhere('a.name like ?',"%".$agent_name."%");
        }
       
       
       $q->innerJoin('s.Agent a');
       $q->innerJoin('s.Branch b');
//       $q->leftJoin('a.PhotoRoot pr');
       $q->leftJoin('b.Translation bt');
       $q->leftJoin('a.Categories c');
       
       if(strlen($sort)){
            $sortArray = explode('_',$sort);
            $q->orderBy($sortArray[0]." ".strtoupper($sortArray[1]));
       }
       else{
           $q->orderBy('rating DESC');
       }
       
       $q->select('b.*,a.id,a.logo,a.name,a.link,bt.*,s.*');

       return $q;
   }
   
   public function searchStaffCount($staff_name,$agent_name,$filters,$hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->staffTable->createQuery('b');
       
       if(strlen($staff_name)){
            $explode = explode(' ',$staff_name,2);
            
            if(count($explode)>0){
                $q->andWhere('(s.firstname like ? and s.lastname like ?) or (s.firstname like ? and s.lastname like ?)',array('%'.$explode[0].'%','%'.$explode[1].'%','%'.$explode[1].'%','%'.$explode[0].'%'));
            }
            else{
                $q->andWhere('(s.firstname like ? or s.lastname like ?)',array('%'.$explode[0].'%','%'.$explode[0].'%'));
            }
        }
        
        if(strlen($agent_name)){
            $q->addWhere('a.name like ?',"%".$agent_name."%");
        }
       
       $q->select('a.*,b.*');
       $q->leftJoin('b.Agent a');
       $q->leftJoin('a.Categories c');
       $q->groupBy('b.id');
       
       return $q->count(array(),$hydrationMode);
   }
   
}

