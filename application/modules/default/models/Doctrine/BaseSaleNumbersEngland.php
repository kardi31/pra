<?php

/**
 * Default_Model_Doctrine_BaseSaleNumbersEngland
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $year
 * @property integer $sales
 * 
 * @package    Admi
 * @subpackage Default
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Default_Model_Doctrine_BaseSaleNumbersEngland extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('default_sale_numbers_england');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('year', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('sales', 'integer', 20, array(
             'type' => 'integer',
             'length' => '20',
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