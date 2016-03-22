<?php

/**
 * Agent_Model_Doctrine_Category
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Admi
 * @subpackage Agent
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Agent_Model_Doctrine_Category extends Agent_Model_Doctrine_BaseCategory
{
    public function getId(){
        return $this->get('id');
    }
    
    public function getMetatagId() {
        return $this->_get('metatag_id');    
    }
}