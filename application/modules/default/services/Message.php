<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Default_Service_Message extends MF_Service_ServiceAbstract {
    
    protected $messageTable;
    protected $messageSendTable;
    
    public function init() {
        $this->messageTable = Doctrine_Core::getTable('Default_Model_Doctrine_Message');
        $this->messageSendTable = Doctrine_Core::getTable('Default_Model_Doctrine_Send');
    }
      
    public function getMessage($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->messageTable->findOneBy($field, $id, $hydrationMode);
    }
    
    public function getMessageForm(Default_Model_Doctrine_Message $message = null){
        $form = new Default_Form_FindSpecialist();
        
        if($message){
            $form->populate($message->toArray());
        }
        
        return $form;
    }
    
    public function getAdminMessageForm(Default_Model_Doctrine_Message $message = null){
        $form = new Default_Form_FindSpecialistAdmin();
        
        if($message){
            $form->populate($message->toArray());
        }
        
        return $form;
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
    
    
   
   public function saveMessageFromArray($values) {

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$category = $this->messageTable->getProxy($values['id'])) {
            $category = $this->messageTable->getRecord();
        }
       
        $category->fromArray($values);
 
       
        $category->save();
       
        return $category;
    }
    
    public function saveMessageSendFromArray($values) {

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$category = $this->messageSendTable->getProxy($values['id'])) {
            $category = $this->messageSendTable->getRecord();
        }
       
        $category->fromArray($values);
 
       
        $category->save();
       
    }
    
}

