<?php

/**
 * Staff_Model_Doctrine_BaseUpdateRequest
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $branch_id
 * @property string $activation_code
 * @property boolean $activated
 * @property Doctrine_Collection $Updates
 * @property Doctrine_Collection $UpdatesDelete
 * @property Doctrine_Collection $UpdatesMerge
 * 
 * @package    Admi
 * @subpackage Staff
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Staff_Model_Doctrine_BaseUpdateRequest extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('staff_update_request');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('branch_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('activation_code', 'string', 255, array(
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
        $this->hasMany('Staff_Model_Doctrine_Update as Updates', array(
             'local' => 'id',
             'foreign' => 'request_id'));

        $this->hasMany('Staff_Model_Doctrine_UpdateDelete as UpdatesDelete', array(
             'local' => 'id',
             'foreign' => 'request_id'));

        $this->hasMany('Staff_Model_Doctrine_UpdateMerge as UpdatesMerge', array(
             'local' => 'id',
             'foreign' => 'request_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}