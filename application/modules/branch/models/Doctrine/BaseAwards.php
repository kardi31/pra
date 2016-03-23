<?php

/**
 * Branch_Model_Doctrine_BaseAwards
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $branch_id
 * @property integer $year
 * @property integer $rank
 * @property string $agent
 * @property string $address
 * @property string $district
 * @property string $town
 * @property string $county
 * @property string $postcode
 * @property string $region
 * @property integer $reviews
 * @property integer $stars
 * @property float $rating
 * @property string $capacity
 * @property boolean $transparent
 * @property Branch_Model_Doctrine_Branch $Branch
 * 
 * @package    Admi
 * @subpackage Branch
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Branch_Model_Doctrine_BaseAwards extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('branch_award');
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
        $this->hasColumn('year', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('rank', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('agent', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('address', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('district', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('town', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('county', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('postcode', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('region', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('reviews', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('stars', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('rating', 'float', 5, array(
             'type' => 'float',
             'length' => '5',
             'scale' => '2',
             ));
        $this->hasColumn('capacity', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('transparent', 'boolean', null, array(
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
        $this->hasOne('Branch_Model_Doctrine_Branch as Branch', array(
             'local' => 'branch_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}