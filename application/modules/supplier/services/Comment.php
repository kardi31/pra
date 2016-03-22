<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Supplier_Service_Comment extends MF_Service_ServiceAbstract {
    
    protected $commentTable;
    
    public function init() {
        $this->commentTable = Doctrine_Core::getTable('Supplier_Model_Doctrine_Comment');
    }
      
    public function getComment($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->commentTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllComments(){
       return $this->commentTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->commentTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveCommentFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->commentTable->getProxy($values['id'])) {
            $record = $this->commentTable->getRecord();
        }
        
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
}

