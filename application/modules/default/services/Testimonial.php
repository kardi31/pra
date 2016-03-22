<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Default_Service_Testimonial extends MF_Service_ServiceAbstract {
    
    protected $testimonialTable;
    protected $testimonialCommentTable;
    
    public function init() {
        $this->testimonialTable = Doctrine_Core::getTable('Default_Model_Doctrine_Testimonial');
        $this->testimonialCommentTable = Doctrine_Core::getTable('Default_Model_Doctrine_TestimonialComment');
    }
      
    public function getDefault($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->testimonialTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllDefaults(){
       return $this->testimonialTable->findAll();
   }
    
    public function saveTestimonialFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->testimonialTable->getProxy($values['id'])) {
            $record = $this->testimonialTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
    public function saveTestimonialCommentFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->testimonialCommentTable->getProxy($values['id'])) {
            $record = $this->testimonialCommentTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
}

