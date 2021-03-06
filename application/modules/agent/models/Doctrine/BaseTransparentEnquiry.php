<?php

/**
 * Agent_Model_Doctrine_BaseTransparentEnquiry
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $capacity
 * @property string $firstname
 * @property string $lastname
 * @property string $email
 * @property string $tel
 * @property clob $message
 * @property string $postcode
 * @property string $ip
 * @property string $hostname
 * @property string $search
 * @property string $pagetype
 * @property string $from_page
 * @property string $address
 * 
 * @package    Admi
 * @subpackage Agent
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Agent_Model_Doctrine_BaseTransparentEnquiry extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('agent_transparent_enquiry');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('capacity', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('firstname', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('lastname', 'string', 255, array(
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
        $this->hasColumn('message', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('postcode', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('ip', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('hostname', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('search', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('pagetype', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('from_page', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('address', 'string', 255, array(
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
        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}