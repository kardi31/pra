<?php

/**
 * UserService
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class User_Service_Mail extends MF_Service_ServiceAbstract {
    
    protected $template = 'email/template.phtml';
    
    public function init() {
        parent::init();
    }
    
    public function sendBranchAddedMail($user,$branch,$password, Zend_Mail $mail, Zend_View_Interface $view, $partial = 'email/branch-added.phtml') {
        
        $view->addScriptPath(APPLICATION_PATH.'/modules/user/views/scripts/');
        $mail->setBodyHtml(
            $view->partial($this->template, array('content' => $view->partial($partial, array('user' => $user,'branch' => $branch,'password' => $password))))
        );
        
        $mail->send();
    }
    
    public function sendBranchContactMail($values,$branch, Zend_Mail $mail, Zend_View_Interface $view, $partial = 'email/contact-branch.phtml') {
        
        $view->addScriptPath(APPLICATION_PATH.'/modules/user/views/scripts/');
        $mail->setBodyHtml(
            $view->partial($this->template, array('content' => $view->partial($partial, array('values' => $values,'branch' => $branch))))
        );
        
        $mail->send();
    }
    
    public function sendContactMail($values, Zend_Mail $mail, Zend_View_Interface $view, $partial = 'email/contact.phtml') {
        
        $view->addScriptPath(APPLICATION_PATH.'/modules/user/views/scripts/');
        $mail->setBodyHtml(
            $view->partial($this->template, array('content' => $view->partial($partial, array('values' => $values))))
        );
        $mail->send();
    }
    
    public function sendSpecialistContactMail($values,$branch, Zend_Mail $mail, Zend_View_Interface $view, $partial = 'email/contact-specialist.phtml') {
        
        $view->addScriptPath(APPLICATION_PATH.'/modules/user/views/scripts/');
        $mail->setBodyHtml(
            $view->partial($this->template, array('content' => $view->partial($partial, array('values' => $values,'branch' => $branch))))
        );
        
        $mail->send();
    }
    
    public function sendActivationEmail($review, Zend_Mail $mail, Zend_View_Interface $view, $partial = 'email/activate-review.phtml') {
        
        $view->addScriptPath(APPLICATION_PATH.'/modules/user/views/scripts/');
        $mail->setBodyHtml(
            $view->partial($this->template, array('content' => $view->partial($partial, array('token' => $review['activation_code']))))
        );
        
        $mail->send();
    }
    
    public function sendCommentActivationEmail($review, Zend_Mail $mail, Zend_View_Interface $view, $partial = 'email/activate-comment.phtml') {
        
        $view->addScriptPath(APPLICATION_PATH.'/modules/user/views/scripts/');
        $mail->setBodyHtml(
            $view->partial($this->template, array('content' => $view->partial($partial, array('token' => $review['activation_code']))))
        );
        
        $mail->send();
    }
    
    public function sendReviewApprovedEmail($review, Zend_Mail $mail, Zend_View_Interface $view, $partial = 'email/review-approved.phtml') {
        
        $view->addScriptPath(APPLICATION_PATH.'/modules/user/views/scripts/');
        $mail->setBodyHtml(
            $view->partial($this->template, array('content' => $view->partial($partial, array('review' => $review))))
        );
        $mail->send();
    }
    
    public function sendCommentApprovedEmail($comment, Zend_Mail $mail, Zend_View_Interface $view, $partial = 'email/comment-approved.phtml') {
        
        $view->addScriptPath(APPLICATION_PATH.'/modules/user/views/scripts/');
        $mail->setBodyHtml(
            $view->partial($this->template, array('content' => $view->partial($partial, array('comment' => $comment))))
        );
        $mail->send();
    }
    
    
    public function sendReviewApprovedEmailForReviewer($review, Zend_Mail $mail, Zend_View_Interface $view, $partial = 'email/review-approved-for-reviewer.phtml') {
        
        $view->addScriptPath(APPLICATION_PATH.'/modules/user/views/scripts/');
        $mail->setBodyHtml(
            $view->partial($this->template, array('content' => $view->partial($partial, array('review' => $review))))
        );
        $mail->send();
    }
    
    
    
    public function sendUpdateMail($type = User_Model_Doctrine_Update::TYPE_PASSWORD, $user, $token, Zend_Mail $mail, Zend_View_Interface $view, $partial = 'email/update.phtml') {
        $mail->addTo($user->getEmail());
        $mail->setBodyText(
                $view->partial($partial, array('user' => $user, 'token' => $token, 'type' => $type))
        );
        $mail->send(); 
    }
    
    public function removeClient(User_Model_Doctrine_User $user, User_Model_Doctrine_Profile $profile) {
         $user->unlink('Groups');
         $user->save();
         $user->delete();
         $profile->delete();
    }
    
    public function removeAdmin(User_Model_Doctrine_User $user) {
        $user->delete();
    }
    
    public function refreshStatusClient($user){
        if ($user->isStatus()):
            $user->setStatus(0);
        else:
            $user->setStatus(1);
        endif;
        $user->save();
    }
    
    public function sendAdminChangePasswordMail(User_Model_User_Interface $user, Zend_Mail $mail, Zend_View_Interface $view, $partial = 'email/admin-change-password.phtml') {
        $token = $user->getToken();                     
        $mail->setBodyHtml(
            $view->partial($partial, array('token' => $token))
        );
        $mail->send();
    }
    
    public function getAllClients($hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->userTable->getClientQuery();
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getTargetClientSelectOptions($prependEmptyValue = false) {
        $items = $this->getAllClients();
        $result = array();
        if($prependEmptyValue) {
            $result[''] = ' ';
        }
        foreach($items as $item) {
                $result[$item->getId()] = $item->first_name.' '.$item->last_name;
        }
        return $result;
    }
    
    public function getUnSelectedDiscountSelectOptions($discountId) {
        $q = $this->userTable->getClientQuery();
        $q->andWhere('cli.discount_id != ? OR cli.discount_id IS NULL', $discountId);
        $items = $q->execute(array(), $hydrationMode);
        $result = array();
        foreach($items as $item) {
                $result[$item->getId()] = $item->first_name.' '.$item->last_name;
        }
        return $result;
    }
    
    public function getSelectedDiscountSelectOptions($discountId) {
        $q = $this->userTable->getClientQuery();
        $q->andWhere('cli.discount_id = ?', $discountId);
        $items = $q->execute(array(), $hydrationMode);
        $result = array();
        foreach($items as $item) {
                $result[$item->getId()] = $item->first_name.' '.$item->last_name;
        }
        return $result;
    }
    
    public function unSelectDiscountUsers($selectedUsers, $newSelectedUsers){
        foreach($selectedUsers as $key => $selectedUser):
            $flag = false;
            foreach($newSelectedUsers as $newSelectedUser):
                if ($key == $newSelectedUser):
                    $flag = true;
                endif;
            endforeach;
            if ($flag == false):
                $user = $this->getUser($key);
                $user->setDiscountId(NULL);
                $user->save();
            endif;
        endforeach;
    }
    
    public function saveAssignedDiscountsFromArray($values, $discountId){
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        $selectedUsers = $this->getSelectedDiscountSelectOptions($discountId);
        $this->unSelectDiscountUsers($selectedUsers, $values['user_selected']);
        foreach($values['user_selected'] as $value):
            $user = $this->getUser($value);
            $user->setDiscountId($discountId);
            $user->save();
        endforeach;
    }
    
    public function getCommentForm(Product_Model_Doctrine_Comment $comment = null) {
        $form = new User_Form_Comment();
        if(null != $comment) { 
            $form->populate($comment->toArray());
        }
        return $form;
    }
    
}

