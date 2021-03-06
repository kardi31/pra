<?php

/**
 * Property_Model_Doctrine_BaseSale
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $property_id
 * @property integer $price_qualifier
 * @property integer $tenure_type_id
 * @property Property_Model_Doctrine_Property $Property
 * 
 * @package    Admi
 * @subpackage Property
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Property_Model_Doctrine_BaseSale extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('property_sale');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('property_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('price_qualifier', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('tenure_type_id', 'integer', 4, array(
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
        $this->hasOne('Property_Model_Doctrine_Property as Property', array(
             'local' => 'property_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}