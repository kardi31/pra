<?php

/**
 * Branch_Model_Doctrine_BaseAttraction
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $agent_id
 * @property string $office_name
 * @property string $office_link
 * @property string $address
 * @property string $borough
 * @property string $citycompass
 * @property string $town
 * @property string $county
 * @property string $country
 * @property string $postcode
 * @property string $tel
 * @property string $fax
 * @property string $email
 * @property string $url
 * @property boolean $view
 * @property boolean $subscribe
 * @property float $rating
 * @property integer $votes
 * @property integer $rank
 * @property integer $rank_town
 * @property integer $rank_district
 * @property integer $rank_country
 * @property integer $rank_postcode
 * @property string $postcode1
 * @property integer $branch_rank
 * @property string $lat
 * @property string $lng
 * @property string $logo
 * @property string $biglogo
 * @property boolean $subscribe_to_ranking_emails
 * @property boolean $subscribe_to_supplier_emails
 * @property boolean $subscribe_to_quarterly_emails
 * @property clob $description
 * @property string $facebook
 * @property string $twitter
 * @property string $video
 * @property timestamp $last_updated
 * @property timestamp $last_emailed
 * @property boolean $premium_support
 * @property integer $fee_satisfaction
 * @property integer $price_satisfaction
 * @property boolean $featured_branch
 * @property boolean $featured_global
 * @property boolean $featured_district
 * @property boolean $featured_town
 * @property boolean $featured_county
 * @property boolean $featured_postcode
 * 
 * @package    Admi
 * @subpackage Branch
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Branch_Model_Doctrine_BaseAttraction extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('branch_branch');
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
        $this->hasColumn('office_name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('office_link', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('address', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('borough', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('citycompass', 'string', 255, array(
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
        $this->hasColumn('country', 'string', 255, array(
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
        $this->hasColumn('view', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 1,
             ));
        $this->hasColumn('subscribe', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 1,
             ));
        $this->hasColumn('rating', 'float', 5, array(
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
        $this->hasColumn('rank_town', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('rank_district', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('rank_country', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('rank_postcode', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('postcode1', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('branch_rank', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('lat', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('lng', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('logo', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('biglogo', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('subscribe_to_ranking_emails', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('subscribe_to_supplier_emails', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('subscribe_to_quarterly_emails', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('description', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('facebook', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('twitter', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('video', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('last_updated', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('last_emailed', 'timestamp', null, array(
             'type' => 'timestamp',
             ));
        $this->hasColumn('premium_support', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('fee_satisfaction', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('price_satisfaction', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('featured_branch', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('featured_global', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('featured_district', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('featured_town', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('featured_county', 'boolean', null, array(
             'type' => 'boolean',
             'default' => 0,
             ));
        $this->hasColumn('featured_postcode', 'boolean', null, array(
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
        $timestampable0 = new Doctrine_Template_Timestampable();
        $softdelete0 = new Doctrine_Template_SoftDelete();
        $this->actAs($timestampable0);
        $this->actAs($softdelete0);
    }
}