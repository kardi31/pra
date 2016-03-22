<?php

/**
 * Advertisment_Model_Doctrine_BaseCategoryGroup
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $user_id
 * @property integer $metatag_id
 * @property integer $last_user_id
 * @property string $title
 * @property string $slug
 * @property clob $content
 * @property Doctrine_Collection $Categories
 * 
 * @package    Admi
 * @subpackage Advertisment
 * @author     Michał Folga <michalfolga@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Advertisment_Model_Doctrine_BaseCategoryGroup extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('advertisment_category_group');
        $this->hasColumn('id', 'integer', 4, array(
             'primary' => true,
             'autoincrement' => true,
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('metatag_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('last_user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('slug', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('content', 'clob', null, array(
             'type' => 'clob',
             ));

        $this->option('type', 'MyISAM');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Advertisment_Model_Doctrine_Category as Categories', array(
             'local' => 'id',
             'foreign' => 'group_id'));

        $i18n0 = new Doctrine_Template_I18n(array(
             'fields' => 
             array(
              0 => 'title',
              1 => 'slug',
              2 => 'content',
             ),
             'tableName' => 'advertisment_category_group_translation',
             'className' => 'CategoryGroupTranslation',
             ));
        $this->actAs($i18n0);
    }
}