<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Property_Service_Property extends MF_Service_ServiceAbstract {
    
    protected $propertyTable;
    
    public function init() {
        $this->propertyTable = Doctrine_Core::getTable('Property_Model_Doctrine_Property');
    }
      
    public function getAgent($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->propertyTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllAgents(){
       return $this->propertyTable->findAll();
   }
   
   public function getAgentPropertyPriceRange($agent_id){
       $q = $this->propertyTable->createQuery('p');
       $q->addWhere('p.agent_id = ?',$agent_id);
       $q->addSelect('max(p.price) as max_let_price');
       $q->addSelect('min(p.price) as min_let_price');
       $q->groupBy('p.agent_id');
       $q->addWhere('trans_type_id = 1');
       $q->addWhere('p.price > 0');
       $resultLet = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
       
       $q = $this->propertyTable->createQuery('p');
       $q->addWhere('p.agent_id = ?',$agent_id);
       $q->addSelect('max(p.price) as max_sale_price');
       $q->addSelect('min(p.price) as min_sale_price');
       $q->addWhere('trans_type_id != 1');
       $q->groupBy('p.agent_id');
       $q->addWhere('p.price > 0');
       $resultSale = $q->fetchOne(array(),Doctrine_Core::HYDRATE_ARRAY);
       
       if(is_array($resultLet)&&is_array($resultSale)){
           return array_merge($resultLet,$resultSale);
       }
       elseif(is_array($resultLet)){
           return $resultLet;
       }
       elseif(is_array($resultSale)){
           return $resultSale;
       }
       else{
           return false;
       }       
   }
    
    public function savePropertyFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->propertyTable->getProxy($values['id'])) {
            $record = $this->propertyTable->getRecord();
        }
        $record->fromArray($values);
        $record->save();
        
        return $record;
    }
    
}

