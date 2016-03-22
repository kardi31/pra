<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version1 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->createTable('advertisment_article', array(
             'id' => 
             array(
              'primary' => '1',
              'autoincrement' => '1',
              'type' => 'integer',
              'length' => '4',
             ),
             'category_id' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'author_id' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'last_editor_id' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'publish' => 
             array(
              'type' => 'boolean',
              'default' => '1',
              'length' => '25',
             ),
             'publish_date' => 
             array(
              'type' => 'timestamp',
              'length' => '25',
             ),
             'created_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'updated_at' => 
             array(
              'notnull' => '1',
              'type' => 'timestamp',
              'length' => '25',
             ),
             'deleted_at' => 
             array(
              'notnull' => '',
              'type' => 'timestamp',
              'length' => '25',
             ),
             ), array(
             'type' => 'MyISAM',
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_general_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('advertisment_article_translation', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '4',
              'primary' => '1',
             ),
             'title' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'slug' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'content' => 
             array(
              'type' => 'clob',
              'length' => '',
             ),
             'meta_description' => 
             array(
              'type' => 'clob',
              'length' => '',
             ),
             'meta_keywords' => 
             array(
              'type' => 'clob',
              'length' => '',
             ),
             'lang' => 
             array(
              'fixed' => '1',
              'primary' => '1',
              'type' => 'string',
              'length' => '2',
             ),
             ), array(
             'type' => 'MyISAM',
             'primary' => 
             array(
              0 => 'id',
              1 => 'lang',
             ),
             'collate' => 'utf8_general_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('advertisment_category', array(
             'id' => 
             array(
              'primary' => '1',
              'autoincrement' => '1',
              'type' => 'integer',
              'length' => '4',
             ),
             'options' => 
             array(
              'type' => 'array',
              'length' => '1000',
             ),
             ), array(
             'type' => 'MyISAM',
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_general_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('advertisment_category_translation', array(
             'id' => 
             array(
              'type' => 'integer',
              'length' => '4',
              'primary' => '1',
             ),
             'name' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'slug' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'lang' => 
             array(
              'fixed' => '1',
              'primary' => '1',
              'type' => 'string',
              'length' => '2',
             ),
             ), array(
             'type' => 'MyISAM',
             'primary' => 
             array(
              0 => 'id',
              1 => 'lang',
             ),
             'collate' => 'utf8_general_ci',
             'charset' => 'utf8',
             ));
    }

    public function down()
    {
        $this->dropTable('advertisment_article');
        $this->dropTable('advertisment_article_translation');
        $this->dropTable('advertisment_category');
        $this->dropTable('advertisment_category_translation');
    }
}