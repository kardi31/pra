<?php

/**
 * Advertisment_Service_Advertisment
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class Advertisment_Service_Category extends MF_Service_ServiceAbstract{
    
    protected $categoryTable;
    
    public function init() {
        $this->categoryTable = Doctrine_Core::getTable('Advertisment_Model_Doctrine_Category');
    }
    
    public function getAllCategories($countOnly = false) {
        if(true == $countOnly) {
            return $this->categoryTable->count();
        } else {
            return $this->categoryTable->findAll();
        }
    }
    
    public function getCategory($id, $field = 'id', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        return $this->categoryTable->findOneBy($field, $id, $hydrationMode);
    }
    
   
    public function getFullCategory($id, $field = 'id',$language='pl', $hydrationMode = Doctrine_Core::HYDRATE_RECORD) {
        $q = $this->categoryTable->getCategoryQuery();
        if(in_array($field, array('id'))) {
            $q->andWhere('c.' . $field . ' = ?', array($id));
        } elseif(in_array($field, array('slug'))) {
            $q->andWhere('ct.' . $field . ' = ?', array($id));
            $q->andWhere('ct.lang = ?', $language);
        }
        
        return $q->fetchOne(array(), $hydrationMode);
    }
   
    
    public function getCategoryForm(Advertisment_Model_Doctrine_Category $category = null) {
         
       
        $form = new Advertisment_Form_Category();
        if($category!=null)
            $form->populate($category->toArray());
        
        return $form;
    }
    
    public function saveCategoryFromArray($values) {

        foreach($values as $key => $value) {
            if(!is_array($value) && strlen($value) == 0) {
                $values[$key] = NULL;
            }
        }
        if(!$category = $this->categoryTable->getProxy($values['id'])) {
            $category = $this->categoryTable->getRecord();
        }
       
        $category->slug = MF_Text::createUniqueTableSlug('Advertisment_Model_Doctrine_Category', $values['title'], $category->getId());
              
        
        $category->fromArray($values);
 
        $category->save();
       
        return $category;
    }
    
    public function removeCategory(Advertisment_Model_Doctrine_Category $category) {
        $category->delete();
    }
    
    public function prependCategoryOptions() {
       
       $options = array('' => '');
       $categories = $this->getAllCategories();
       
       foreach($categories as $category):
           $options[$category['Group']['Translation']['pl']['title']][$category['id']] = $category['Translation']['pl']['title'];
       endforeach;
       return $options;
    }
     
   
}

