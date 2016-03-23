<?php

/**
 * Default_Model_Doctrine_BaseRedirect
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $old
 * @property string $new
 * @property integer $branch_id
 * @property integer $agent_id
 * 
 * @package    Admi
 * @subpackage Default
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Default_Model_Doctrine_BaseRedirect extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('default_redirect');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('old', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('new', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('branch_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('agent_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));

        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}