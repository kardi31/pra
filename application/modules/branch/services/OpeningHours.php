<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_Service_OpeningHours extends MF_Service_ServiceAbstract {
    
    protected $openingHoursTable;
    
    public function init() {
        $this->openingHoursTable = Doctrine_Core::getTable('Branch_Model_Doctrine_OpeningHours');
    }
      
    public function getBranch($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->openingHoursTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllBranchs(){
       return $this->openingHoursTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->openingHoursTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    
    public function saveOpeningHoursFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        for($i=1;$i<=7;$i++):
            $field_name = strtolower(jddayofweek($i-1, 2));
            if(isset($values['closed_'.$field_name])&&$values['closed_'.$field_name]){
                $openingHours = $this->openingHoursTable->getRecord();
                $openingHours->set('day_id',$i);
                $openingHours->set('closed',1);
            }
            elseif(isset($values['start_'.$field_name])&&$values['start_'.$field_name]!='00:00'){
                $openingHours = $this->openingHoursTable->getRecord();
                $openingHours->set('day_id',$i);
                $openingHours->set('from',$values['start_'.$field_name].":00");
                $openingHours->set('to',$values['end_'.$field_name].":00");
                
            }
            
            $openingHours->set('branch_id',$values['branch_id']);
            $openingHours->save();
        endfor;
       
    }
}

