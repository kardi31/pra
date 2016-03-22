<?php

/**
 * Advertising_Model_Doctrine_BaseSize
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $size
 * @property string $value
 * @property Doctrine_Collection $Advertising
 * 
 * @package    Admi
 * @subpackage Advertising
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Advertising_Model_Doctrine_BaseSize extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('advertising_size');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('size', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('value', 'string', 255, array(
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
        $this->hasMany('Advertising_Model_Doctrine_Advertising as Advertising', array(
             'local' => 'id',
             'foreign' => 'size_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}