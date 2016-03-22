<?php

/**
 * Default_Model_Doctrine_BaseBanned
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $ip
 * @property string $hostname
 * @property clob $notes
 * 
 * @package    Admi
 * @subpackage Default
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Default_Model_Doctrine_BaseBanned extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('default_banned');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('ip', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('hostname', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('notes', 'clob', null, array(
             'type' => 'clob',
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