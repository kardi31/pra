<?php

/**
 * Staff_Model_Doctrine_BasePhotoClaim
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $staff_id
 * @property string $photo_name
 * @property string $activation_code
 * @property string $expiration_date
 * @property boolean $activated
 * @property Staff_Model_Doctrine_Staff $Staff
 * 
 * @package    Admi
 * @subpackage Staff
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Staff_Model_Doctrine_BasePhotoClaim extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('staff_photo_claim');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('staff_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('photo_name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('activation_code', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('expiration_date', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('activated', 'boolean', null, array(
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
        $this->hasOne('Staff_Model_Doctrine_Staff as Staff', array(
             'local' => 'staff_id',
             'foreign' => 'id'));
    }
}