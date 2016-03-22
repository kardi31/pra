<?php

/**
 * Agent_Model_Doctrine_BaseNotes
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $agent_id
 * @property clob $note
 * @property integer $sales_guy
 * @property timestamp $callback
 * @property boolean $done
 * @property Agent_Model_Doctrine_Agent $Agent
 * 
 * @package    Admi
 * @subpackage Agent
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Agent_Model_Doctrine_BaseNotes extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('agent_notes');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('agent_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('note', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('sales_guy', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('callback', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('done', 'boolean', null, array(
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
        $this->hasOne('Agent_Model_Doctrine_Agent as Agent', array(
             'local' => 'agent_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}