<?php

/**
 * News_Form_News
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_Form_RankingSearch extends Admin_Form {
    
    public function init() {
        $id = $this->createElement('hidden', 'id');
        $id->setDecorators(array('ViewHelper'));
        
        
        $categoryId = $this->createElement('select', 'category_id');
        $categoryId->setLabel('Category');
        $categoryId->setDecorators(self::$selectDecorators);
        $categoryId->setAttrib('class', 'form-control');
        
        $area = $this->createElement('text', 'area');
        $area->setLabel('Area (town, region or postcode)');
        $area->setDecorators(self::$textDecorators);
        $area->setAttrib('class', 'form-control');
        
        
        $name = $this->createElement('text', 'name');
        $name->setLabel('Company name');
        $name->setDecorators(self::$textDecorators);
        $name->setAttrib('class', 'form-control');
        
       
        
        $submit = $this->createElement('button', 'submit');
        $submit->setLabel('Search');
        $submit->setDecorators(array('ViewHelper'));
        $submit->setAttribs(array('class' => 'btn btn-info', 'type' => 'submit'));

        $this->setElements(array(
            $id,
            $categoryId,
            $name,
            $area,
            $submit
        ));
    }
}

