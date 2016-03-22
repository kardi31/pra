<?php

/**
 * Staff_Model_Doctrine_BaseStaffTranslation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $lang
 * @property clob $description
 * @property Staff_Model_Doctrine_Staff $Staff
 * 
 * @package    Admi
 * @subpackage Staff
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Staff_Model_Doctrine_BaseStaffTranslation extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('staff_staff_translation');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('lang', 'string', 64, array(
             'primary' => true,
             'type' => 'string',
             'length' => '64',
             ));
        $this->hasColumn('description', 'clob', null, array(
             'type' => 'clob',
             ));

        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Staff_Model_Doctrine_Staff as Staff', array(
             'local' => 'id',
             'foreign' => 'id'));
    }
}