<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_Service_Update extends MF_Service_ServiceAbstract {
    
    protected $updateTable;
    
    public function init() {
        $this->updateTable = Doctrine_Core::getTable('Agent_Model_Doctrine_Update');
        $this->updateHoursTable = Doctrine_Core::getTable('Branch_Model_Doctrine_UpdateOpeningHours');
    }
      
    public function getUpdate($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->updateTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllAgents(){
       return $this->updateTable->findAll();
   }
   
   
   public function getAllUpdates($countOnly = false){
       if($countOnly)
           return $this->updateTable->count();
       return $this->updateTable->findAll();
   }
    
   
   
    public function saveUpdateFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->updateTable->getProxy($values['id'])) {
            $record = $this->updateTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
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
                $openingHours = $this->updateHoursTable->getRecord();
                $openingHours->set('day_id',$i);
                $openingHours->set('closed',1);
            }
            elseif(isset($values['start_'.$field_name])&&$values['start_'.$field_name]!='00:00'){
                $openingHours = $this->updateHoursTable->getRecord();
                $openingHours->set('day_id',$i);
                $openingHours->set('from',$values['start_'.$field_name].":00");
                $openingHours->set('to',$values['end_'.$field_name].":00");
                
            }
            $openingHours->set('update_id',$values['update_id']);
            $openingHours->save();
        endfor;
       
    }
    
    public function getUpdateForm(Agent_Model_Doctrine_Update $update = null){
        $form = new Agent_Form_AgentAdmin();
        if(null !== $update) {
            $updateArray = $update->toArray();
            
            
            $updateArray['translations']['pl']['description'] = $updateArray['description'];
            $form->populate($updateArray);
            
            $hoursForm = new Branch_Form_OpeningHours();
            $hoursForm->populateForm($update['Hours']->toArray());
            $form->addSubForm($hoursForm,'hoursForm');
            
            foreach($update['Branches'] as $key => $branch):
                $subform = new Agent_Form_AgentAdmin();
                $updateArray = $branch->toArray();
                $updateArray['translations']['pl']['description'] = $updateArray['description'];
                $subform->populate($updateArray);
                
                $hoursForm = new Branch_Form_OpeningHours();
                $hoursForm->populateForm($branch['Hours']->toArray());
                $subform->addSubForm($hoursForm,'hoursForm');
                
                $form->addSubForm($subform, 'branch'.($key+1));
            endforeach;
            
        }
       
        return $form;
    }
    
    
}

