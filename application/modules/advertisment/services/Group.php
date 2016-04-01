<?php

/**
 * Advertisment_Service_Advertisment
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class Advertisment_Service_Group extends MF_Service_ServiceAbstract{
    
    protected $groupTable;
    
    public function init() {
        $this->groupTable = Doctrine_Core::getTable('Advertisment_Model_Doctrine_Group');
    }
    
    public function getAllGroups($countOnly = false) {
        if(true == $countOnly) {
            return $this->groupTable->count();
        } else {
            return $this->groupTable->findAll();
        }
    }
    
    public function getGroup($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->groupTable->findOneBy($field, $id, $hydrationMode);
    }
   
    public function getGroupsAndCategories($lang = 'pl',$hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->groupTable->createQuery('g');
        $q->select('g.*,c.*,ct.*,gt.*');
        $q->leftJoin('g.Translation gt');
        $q->leftJoin('g.Categories c');
        $q->addWhere('gt.lang = ?', $lang);
        $q->addWhere('ct.lang = ?', $lang);
        $q->leftJoin('c.Translation ct');
        $q->orderBy('gt.title,ct.title');
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getFullGroups($language = 'pl',$hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->groupTable->createQuery('g');
        $q->select('g.*,c.*,gt.*,ct.*,co.id');
        $q->leftJoin('g.Categories c');
        $q->leftJoin('g.Translation gt');
        $q->leftJoin('c.Translation ct');
        $q->leftJoin('c.Advertisments co');
        $q->addWhere('ct.lang = ?',$language);
        $q->addWhere('gt.lang = ?',$language);
        $q->orderBy('gt.title,ct.title');
        return $q->execute(array(), $hydrationMode);
    }
    
    public function getGroupForm(Advertisment_Model_Doctrine_CategoryGroup $group = null) {
         
       
        $form = new Advertisment_Form_Group();
        if($group!=null)
            $form->populate($group->toArray());
        
        return $form;
    }
    
    public function saveGroupFromArray($values) {

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$group = $this->groupTable->getProxy($values['id'])) {
            $group = $this->groupTable->getRecord();
        }
       
        $group->slug = MF_Text::createUniqueTableSlug('Advertisment_Model_Doctrine_CategoryGroup', $values['title'], $group->getId());
              
        
        $group->fromArray($values);
 
        $group->save();
       
        return $group;
    }
    
    public function removeGroup(Advertisment_Model_Doctrine_Group $group) {
        $group->delete();
    }
    
    public function prependGroupOptions() {
       
       $options = array('' => '');
       $categories = $this->getAllGroups();
       
       foreach($categories as $group):
           $options[$group['id']] = $group['title'];
       endforeach;
       
       return $options;
    }
     
   
}

