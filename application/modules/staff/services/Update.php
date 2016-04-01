<?php

/**
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Staff_Service_Update extends MF_Service_ServiceAbstract {
    
    protected $updateTable;
    
    public function init() {
        $this->updateTable = Doctrine_Core::getTable('Staff_Model_Doctrine_Update');
    }
      
    public function getUpdate($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->updateTable->findOneBy($field, $id, $hydrationMode);
    }
   public function getAllUpdates(){
       return $this->updateTable->findAll();
   }
    
    public function saveUpdateFromArray($values) {
        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        
        if(!$update = $this->updateTable->getProxy($values['id'])) {
            $update = $this->updateTable->getRecord();
        }
        
        $update->fromArray($values);
        $update->save();
        
        return $update;
    }
    
    public function getUpdateAdminForm(Staff_Model_Doctrine_Update $update = null) {
        $currentStaffForm = new Staff_Form_StaffAdmin();
        $updateStaffForm = new Staff_Form_StaffAdmin();
        $updateStaffForm->removeElement('branch_id');
        if(null != $update) {
            $bannerArray = $update->toArray();
            $updateStaffForm->populate($bannerArray);
            
            $currentStaffForm->populate($update['Staff']->toArray());
            
            $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
            $languages = $i18nService->getLanguageList();
            foreach($languages as $language) {
                $i18nSubform = $currentStaffForm->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('description')->setValue($update['Staff']->Translation[$language]->description);
                }
                $i18nSubform = $updateStaffForm->translations->getSubForm($language);
                if($i18nSubform) {
                    $i18nSubform->getElement('description')->setValue($update->description);
                }
            }
        }   
        
        $updateStaffForm->addSubForm($currentStaffForm, 'currentStaffForm');
        
        return $updateStaffForm;
    }
    
    public function approveStaffUpdateFromArray(Staff_Model_Doctrine_Update $update,$values){
        $i18nService = MF_Service_ServiceBroker::getInstance()->getService('Default_Service_I18n');
        $staff = $update->get('Staff');
        
        $staff->fromArray($values);
        $languages = $i18nService->getLanguageList();
        $staff->link = MF_Text::createUniqueTableField('Staff_Model_Doctrine_Staff','link', $values['firstname']." ".$values['lastname'], $staff->get('id'));
        foreach($languages as $language) {
            if(is_array($values['translations'][$language]) && strlen($values['translations'][$language]['description'])) {                             
                $staff->Translation[$language]->description = $values['translations'][$language]['description'];
            }
        }
        
        $staff->save();
        $update->delete();
        
    }
    
}

