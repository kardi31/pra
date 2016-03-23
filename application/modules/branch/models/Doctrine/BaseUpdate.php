<?php

/**
 * Branch_Model_Doctrine_BaseUpdate
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $branch_id
 * @property string $contact_name
 * @property string $contact_email
 * @property string $contact_tel
 * @property string $contact_job
 * @property string $address
 * @property string $district
 * @property string $town
 * @property string $county
 * @property string $postcode
 * @property string $tel
 * @property string $fax
 * @property string $email
 * @property string $url
 * @property clob $about
 * @property clob $fees
 * @property clob $complaints
 * @property string $video
 * @property string $twitter
 * @property string $facebook
 * @property date $date_added
 * @property boolean $deleted
 * @property Branch_Model_Doctrine_Update $Branch
 * @property Doctrine_Collection $Updates
 * @property Doctrine_Collection $AreasCovered
 * @property Doctrine_Collection $OpeningHours
 * 
 * @package    Admi
 * @subpackage Branch
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Branch_Model_Doctrine_BaseUpdate extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('branch_update');
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
        $this->hasColumn('contact_name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('contact_email', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('contact_tel', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('contact_job', 'string', 255, array(
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
        $this->hasColumn('tel', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('fax', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('url', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('about', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('fees', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('complaints', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('video', 'string', 255, array(
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
        $this->hasColumn('date_added', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('deleted', 'boolean', null, array(
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
        $this->hasOne('Branch_Model_Doctrine_Update as Branch', array(
             'local' => 'branch_id',
             'foreign' => 'id'));

        $this->hasMany('Branch_Model_Doctrine_Update as Updates', array(
             'local' => 'id',
             'foreign' => 'branch_id'));

        $this->hasMany('Branch_Model_Doctrine_UpdateAreaCovered as AreasCovered', array(
             'local' => 'id',
             'foreign' => 'update_id'));

        $this->hasMany('Branch_Model_Doctrine_UpdateOpeningHours as OpeningHours', array(
             'local' => 'id',
             'foreign' => 'update_id'));
    }
}