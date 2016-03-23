<?php

/**
 * Staff_Model_Doctrine_BaseClaim
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $staff_id
 * @property string $title
 * @property string $firstname
 * @property string $lastname
 * @property string $tel
 * @property string $mob
 * @property string $email
 * @property string $sex
 * @property clob $comment
 * @property date $dob
 * @property string $birthplace
 * @property string $sport
 * @property string $team
 * @property string $twitter
 * @property string $facebook
 * @property string $linkedin
 * @property string $activation_code
 * @property Staff_Model_Doctrine_Staff $Staff
 * 
 * @package    Admi
 * @subpackage Staff
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Staff_Model_Doctrine_BaseClaim extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('staff_claim');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('staff_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('firstname', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('lastname', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('tel', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('mob', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('sex', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('comment', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('dob', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('birthplace', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('sport', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('team', 'string', 255, array(
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
        $this->hasColumn('linkedin', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('activation_code', 'string', 255, array(
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
        $this->hasOne('Staff_Model_Doctrine_Staff as Staff', array(
             'local' => 'staff_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}