<?php

/**
 * Supplier_Model_Doctrine_BaseSupplier
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $supplier
 * @property string $link
 * @property integer $rank
 * @property string $address
 * @property string $district
 * @property string $town
 * @property string $county
 * @property string $postcode
 * @property string $email
 * @property string $tel
 * @property string $fax
 * @property string $mob
 * @property string $url
 * @property string $twitter
 * @property string $facebook
 * @property clob $brief_description
 * @property clob $full_description
 * @property string $logo
 * @property Doctrine_Collection $Categories
 * @property Doctrine_Collection $Contacts
 * @property Doctrine_Collection $Reviews
 * 
 * @package    Admi
 * @subpackage Supplier
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Supplier_Model_Doctrine_BaseSupplier extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('supplier_supplier');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('supplier', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('link', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('rank', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
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
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('tel', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('fax', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('mob', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('url', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('twitter', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('facebook', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('brief_description', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('full_description', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('logo', 'string', 255, array(
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
        $this->hasMany('Supplier_Model_Doctrine_Category as Categories', array(
             'refClass' => 'Supplier_Model_Doctrine_SupplierCategory',
             'local' => 'supplier_id',
             'foreign' => 'category_id'));

        $this->hasMany('Supplier_Model_Doctrine_Contact as Contacts', array(
             'local' => 'id',
             'foreign' => 'supplier_id'));

        $this->hasMany('Supplier_Model_Doctrine_Review as Reviews', array(
             'local' => 'id',
             'foreign' => 'supplier_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}