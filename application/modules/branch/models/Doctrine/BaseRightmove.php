<?php

/**
 * Branch_Model_Doctrine_BaseRightmove
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $branch_id
 * @property string $rightmove_branch_id
 * @property string $folder
 * @property string $url
 * @property Branch_Model_Doctrine_Branch $Branch
 * 
 * @package    Admi
 * @subpackage Branch
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Branch_Model_Doctrine_BaseRightmove extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('branch_rightmove');
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
        $this->hasColumn('rightmove_branch_id', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('folder', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('url', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));

        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Branch_Model_Doctrine_Branch as Branch', array(
             'local' => 'branch_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}