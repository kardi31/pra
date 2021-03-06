<?php

/**
 * Review_Model_Doctrine_BaseTemp
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $agent_id
 * @property integer $branch_id
 * @property integer $rating
 * @property bool $recommend
 * @property clob $review
 * @property string $firstname
 * @property string $lastname
 * @property string $phone
 * @property string $display_name
 * @property string $email
 * @property boolean $activated
 * @property string $ip
 * @property string $hostname
 * @property string $activation_code
 * @property clob $feedback
 * @property date $service_date
 * @property string $activation_ip
 * @property string $activation_hostname
 * @property integer $staff
 * @property integer $staff2
 * @property clob $notes
 * 
 * @package    Admi
 * @subpackage Review
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Review_Model_Doctrine_BaseTemp extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('review_temp');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('agent_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('branch_id', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('rating', 'integer', 11, array(
             'type' => 'integer',
             'length' => '11',
             ));
        $this->hasColumn('recommend', 'bool', null, array(
             'type' => 'bool',
             'default' => 0,
             ));
        $this->hasColumn('review', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('firstname', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('lastname', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('phone', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('display_name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('email', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('activated', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('ip', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('hostname', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('activation_code', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('feedback', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('service_date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('activation_ip', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('activation_hostname', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('staff', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('staff2', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
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