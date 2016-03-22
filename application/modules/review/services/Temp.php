<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Review_Service_Temp extends MF_Service_ServiceAbstract {
    
    protected $tempTable;
    
    public function init() {
        $this->tempTable = Doctrine_Core::getTable('Review_Model_Doctrine_Temp');
    }
      
    public function getReview($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->tempTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllReviews(){
       return $this->tempTable->findAll();
   }
   public function getAllActiveAds($hydrationMode = Doctrine_Core::HYDRATE_RECORD){
       $q = $this->tempTable->createQuery('p');
       $q->addWhere('p.publish = 1');
       return $q->execute(array(),$hydrationMode);
   }
   
    public function saveTempFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$record = $this->tempTable->getProxy($values['id'])) {
            $record = $this->tempTable->getRecord();
        }
        $record->fromArray($values);
//        Zend_Debug::dump($record->toArray());exit;
        $record->save();
        
        return $record;
    }
    
    public function getReviewAdminForm(Review_Model_Doctrine_Temp $review = null,  Agent_Model_Doctrine_Agent $agent = null) {
        $form = new Review_Form_ReviewAdmin();
        
        foreach($agent['Branches'] as $branch){
            $form->getElement('branch_id')->addMultiOption($branch['id'],$branch['office_name']." ".$branch['town']." ".$branch['postcode']);
        }
        
        foreach($agent['StaffMembers'] as $staff){
            $form->getElement('staff1')->addMultiOption($staff['id'],$staff['firstname']." ".$staff['lastname']);
            $form->getElement('staff2')->addMultiOption($staff['id'],$staff['firstname']." ".$staff['lastname']);
        }
        if(null != $review) {
            $bannerArray = $review->toArray();
            $form->populate($bannerArray);
//            
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            $languages = $i18nService->getLanguageList();
            foreach($languages as $language) {
                $i18nSubform = $form->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('review')->setValue($review['review']);
                    $i18nSubform->getElement('feedback')->setValue($review['feedback']);
                }
            }
        }
        return $form;
    }
    
}

