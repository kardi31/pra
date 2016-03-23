<?php

/**
 * Default_Model_Doctrine_BaseHousePricesEngland
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $unique_id
 * @property integer $price
 * @property datetime $saledate
 * @property string $postcode
 * @property string $property_type
 * @property boolean $old_new
 * @property string $duration
 * @property string $paon
 * @property string $saon
 * @property string $street
 * @property string $locality
 * @property string $town
 * @property string $district
 * @property string $county
 * @property string $record_status
 * 
 * @package    Admi
 * @subpackage Default
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Default_Model_Doctrine_BaseHousePricesEngland extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('default_house_prices_england');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('unique_id', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('price', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('saledate', 'datetime', null, array(
             'type' => 'datetime',
             ));
        $this->hasColumn('postcode', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('property_type', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('old_new', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('duration', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('paon', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('saon', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('street', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('locality', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('town', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('district', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('county', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('record_status', 'string', 1, array(
             'type' => 'string',
             'length' => '1',
             ));

        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        
    }
}