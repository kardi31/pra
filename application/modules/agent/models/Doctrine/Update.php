<?php

/**
 * Agent_Model_Doctrine_Update
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Admi
 * @subpackage Agent
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Agent_Model_Doctrine_Update extends Agent_Model_Doctrine_BaseUpdate
{
    public function setUp()
    {
        parent::setUp();

        $this->hasMany('Branch_Model_Doctrine_UpdateOpeningHours as Hours', array(
             'local' => 'id',
             'foreign' => 'update_id'));

    }
}