<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Review_Service_Comment extends MF_Service_ServiceAbstract {
    
    protected $commentTable;
    protected $filesTable;
    
    public function init() {
        $this->commentTable = Doctrine_Core::getTable('Review_Model_Doctrine_Comment');
        $this->filesTable = Doctrine_Core::getTable('Review_Model_Doctrine_CommentFiles');
    }
      
    public function getComment($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->commentTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllReviews(){
       return $this->commentTable->findAll();
   }
   
   public function getReviewComments($review_id,$hydrationMode = Doctrine_Core::HYDRATE_ARRAY){
       $q = $this->commentTable->createQuery('c');
       $q->leftJoin('c.Translation ct');
       $q->addWhere('c.review_id = ?',$review_id);
       $q->orderBy('c.created_at DESC');
       $q->select('c.*,ct.*');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveNewCommentFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        $values['ip'] = $_SERVER['REMOTE_ADDR'];
        $values['hostname'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        
        if(!$record = $this->commentTable->getProxy($values['id'])) {
            $record = $this->commentTable->getRecord();
        }
        
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        $record->fromArray($values);
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
                $record->Translation[$language]->comment = $values['comment'];
        }
        
        $record->save();
        
        return $record;
    }
   
    public function saveCommentFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        
        if(!$record = $this->commentTable->getProxy($values['id'])) {
            $record = $this->commentTable->getRecord();
        }
        $record->fromArray($values);
        
        
        $languages = $i18nService->getLanguageList();
        foreach($languages as $language) {
                $record->Translation[$language]->comment = $values['comment'];
        }
        
        $record->save();
        
        return $record;
    }
    
    
   public function activate($comment){
       $values = array();
       
        $values['activation_ip'] = $_SERVER['REMOTE_ADDR'];
        $values['activation_hostname'] = gethostbyaddr($_SERVER['REMOTE_ADDR']);
        $values['activated'] = 1;
        
        $comment->fromArray($values);
        $comment->save();
        
        return $comment;
        
   }
   
   
    public function getCommentAdminForm(Review_Model_Doctrine_Comment $comment = null) {
        $form = new Review_Form_CommentAdmin();
        
        if(null != $comment) {
            $bannerArray = $comment->toArray();
            $form->populate($bannerArray);
//            
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            $languages = $i18nService->getLanguageList();
            foreach($languages as $language) {
                $i18nSubform = $form->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('comment')->setValue($comment['Translation'][$language]['comment']);
                }
            }
        }
        return $form;
    }
    
}

