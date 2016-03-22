<?php

/**
 * Advertisment_Service_Advertisment
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class Advertisment_Service_Comment extends MF_Service_ServiceAbstract{
    
    protected $commentTable;
    
    public function init() {
        $this->commentTable = Doctrine_Core::getTable('Advertisment_Model_Doctrine_Comment');
    }
    
    public function getAllComments($countOnly = false) {
        if(true == $countOnly) {
            return $this->commentTable->count();
        } else {
            return $this->commentTable->findAll();
        }
    }
    
    public function getComment($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->commentTable->findOneBy($field, $id, $hydrationMode);
    }
   
    
    public function getCommentForm(Advertisment_Model_Doctrine_Comment $comment = null) {
         
       
        $form = new Advertisment_Form_Comment();
        if($comment!=null)
            $form->populate($comment->toArray());
        
        return $form;
    }
    
    public function saveCommentFromArray($values) {

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$comment = $this->commentTable->getProxy($values['id'])) {
            $comment = $this->commentTable->getRecord();
        }
       
        $comment->slug = MF_Text::createUniqueTableSlug('Advertisment_Model_Doctrine_Comment', $values['title'], $comment->getId());
              
        
        $comment->fromArray($values);
 
        $comment->save();
       
        return $comment;
    }
    
    public function removeComment(Advertisment_Model_Doctrine_Comment $comment) {
        $comment->delete();
    }
    
    public function prependCommentOptions() {
       
       $options = array('' => '');
       $categories = $this->getAllCategories();
       
       foreach($categories as $comment):
           $options[$comment['id']] = $comment['title'];
       endforeach;
       
       return $options;
    }
     
    public function getAdvertismentComments($advertisment_id, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->commentTable->createQuery('c');
        $q->addWhere('c.advertisment_id = ?',$advertisment_id);
        $q->orderBy('c.id DESC');
        return $q->execute(array(), $hydrationMode);
    }
    
    public function countAdvertismentComments($advertisment_id, $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->commentTable->createQuery('c');
        $q->addSelect('count(c.id) as comment_count');
        $q->addWhere('c.advertisment_id = ?',$advertisment_id);
        $q->groupBy('c.advertisment_id');
        return $q->fetchOne(array(), $hydrationMode);
    }
    
    public function addComment($values) {

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
            
        $comment = $this->commentTable->getRecord();
        $values['user_ip'] = $_SERVER['REMOTE_ADDR'];
        $comment->fromArray($values);
 
        $comment->save();
       
        return $comment;
    }
   
}

