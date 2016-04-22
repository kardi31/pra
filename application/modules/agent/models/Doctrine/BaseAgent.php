<?php

/**
 * Agent_Model_Doctrine_BaseAgent
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property string $name
 * @property string $link
 * @property clob $description
 * @property float $rating
 * @property float $customer_satisfaction
 * @property float $points
 * @property integer $votes
 * @property integer $rank
 * @property integer $view
 * @property integer $views
 * @property string $meta_title
 * @property boolean $premium_support
 * @property integer $logo_root_id
 * @property integer $ad_root_id
 * @property string $facebook
 * @property string $twitter
 * @property boolean $approved
 * @property integer $head_office_id
 * @property Doctrine_Collection $Translation
 * @property Doctrine_Collection $Contacts
 * @property Agent_Model_Doctrine_HistoricRanking $HistoricRanking
 * @property Doctrine_Collection $HistoricRankingWeekly
 * @property Doctrine_Collection $Awards
 * @property Doctrine_Collection $Categories
 * 
 * @package    Admi
 * @subpackage Agent
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Agent_Model_Doctrine_BaseAgent extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('agent_agent');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('link', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('description', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('rating', 'float', 5, array(
             'type' => 'float',
             'length' => '5',
             'scale' => '2',
             ));
        $this->hasColumn('customer_satisfaction', 'float', 5, array(
             'type' => 'float',
             'length' => '5',
             'scale' => '2',
             ));
        $this->hasColumn('points', 'float', 5, array(
             'type' => 'float',
             'length' => '5',
             'scale' => '2',
             ));
        $this->hasColumn('votes', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('rank', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('view', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('views', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('meta_title', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('premium_support', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('logo_root_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('ad_root_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('facebook', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('twitter', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('approved', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 1,
             ));
        $this->hasColumn('head_office_id', 'integer', 4, array(
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
        $this->hasMany('Agent_Model_Doctrine_AgentTranslation as Translation', array(
             'local' => 'id',
             'foreign' => 'id'));

        $this->hasMany('Agent_Model_Doctrine_Contact as Contacts', array(
             'local' => 'id',
             'foreign' => 'agent_id'));

        $this->hasOne('Agent_Model_Doctrine_HistoricRanking as HistoricRanking', array(
             'local' => 'id',
             'foreign' => 'agent_id'));

        $this->hasMany('Agent_Model_Doctrine_HistoricRankingWeekly as HistoricRankingWeekly', array(
             'local' => 'id',
             'foreign' => 'agent_id'));

        $this->hasMany('Agent_Model_Doctrine_Awards as Awards', array(
             'local' => 'id',
             'foreign' => 'agent_id'));

        $this->hasMany('Agent_Model_Doctrine_Category as Categories', array(
             'refClass' => 'Agent_Model_Doctrine_AgentCategory',
             'local' => 'agent_id',
             'foreign' => 'category_id'));

        $i18n0 = new Doctrine_Template_I18n(array(
             'fields' => 
             array(
              0 => 'description',
             ),
             'tableName' => 'agent_agent_translation',
             'className' => 'AgentTranslation',
             ));
        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($i18n0);
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}