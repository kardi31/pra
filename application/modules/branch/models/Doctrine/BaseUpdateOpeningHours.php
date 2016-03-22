<?php

/**
 * Branch_Model_Doctrine_BaseUpdateOpeningHours
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $update_id
 * @property integer $day_id
 * @property time $from
 * @property time $to
 * @property boolean $closed
 * @property Branch_Model_Doctrine_Update $Update
 * 
 * @package    Admi
 * @subpackage Branch
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Branch_Model_Doctrine_BaseUpdateOpeningHours extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('branch_update_opening_hours');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('update_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('day_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('from', 'time', null, array(
             'type' => 'time',
             ));
        $this->hasColumn('to', 'time', null, array(
             'type' => 'time',
             ));
        $this->hasColumn('closed', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));

        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Branch_Model_Doctrine_Update as Update', array(
             'local' => 'update_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}