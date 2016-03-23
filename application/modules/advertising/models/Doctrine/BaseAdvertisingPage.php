<?php

/**
 * Advertising_Model_Doctrine_BaseAdvertisingPage
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $page_id
 * @property integer $ad_id
 * 
 * @package    Admi
 * @subpackage Advertising
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Advertising_Model_Doctrine_BaseAdvertisingPage extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('advertising_advertising_page');
        $this->hasColumn('page_id', 'integer', 4, array(
             'primary' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('ad_id', 'integer', 4, array(
             'primary' => true,
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