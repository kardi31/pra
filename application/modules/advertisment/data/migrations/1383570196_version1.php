<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version1 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropTable('advertisment_serwis1_advertisment_translation');
        $this->dropTable('advertisment_serwis2_advertisment_translation');
        $this->dropTable('advertisment_serwis3_advertisment_translation');
        $this->createTable('advertismentletter_list', array(
             'id' => 
             array(
              'primary' => '1',
              'autoincrement' => '1',
              'type' => 'integer',
              'length' => '4',
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
        $this->createTable('advertismentletter_users', array(
             'id' => 
             array(
              'primary' => '1',
              'autoincrement' => '1',
              'type' => 'integer',
              'length' => '4',
             ),
             'email' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'service_id' => 
             array(
              'type' => 'integer',
              'length' => '4',
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
        $this->addColumn('advertisment_serwis1_advertisment', 'title', 'string', '255', array(
             ));
        $this->addColumn('advertisment_serwis1_advertisment', 'slug', 'string', '255', array(
             ));
        $this->addColumn('advertisment_serwis1_advertisment', 'content', 'clob', '', array(
             ));
        $this->addColumn('advertisment_serwis2_advertisment', 'title', 'string', '255', array(
             ));
        $this->addColumn('advertisment_serwis2_advertisment', 'slug', 'string', '255', array(
             ));
        $this->addColumn('advertisment_serwis2_advertisment', 'content', 'clob', '', array(
             ));
        $this->addColumn('advertisment_serwis3_advertisment', 'title', 'string', '255', array(
             ));
        $this->addColumn('advertisment_serwis3_advertisment', 'slug', 'string', '255', array(
             ));
        $this->addColumn('advertisment_serwis3_advertisment', 'content', 'clob', '', array(
             ));
    }

    public function down()
    {
        $this->createTable('advertisment_serwis1_advertisment_translation', array(
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
             'lang' => 
             array(
              'fixed' => '1',
              'primary' => '1',
              'type' => 'string',
              'length' => '2',
             ),
             ), array(
             'type' => 'MyISAM',
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
              1 => 'lang',
             ),
             'collate' => 'utf8_general_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('advertisment_serwis2_advertisment_translation', array(
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
             'lang' => 
             array(
              'fixed' => '1',
              'primary' => '1',
              'type' => 'string',
              'length' => '2',
             ),
             ), array(
             'type' => 'MyISAM',
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
              1 => 'lang',
             ),
             'collate' => 'utf8_general_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('advertisment_serwis3_advertisment_translation', array(
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
             'lang' => 
             array(
              'fixed' => '1',
              'primary' => '1',
              'type' => 'string',
              'length' => '2',
             ),
             ), array(
             'type' => 'MyISAM',
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
              1 => 'lang',
             ),
             'collate' => 'utf8_general_ci',
             'charset' => 'utf8',
             ));
        $this->dropTable('advertismentletter_list');
        $this->dropTable('advertismentletter_users');
        $this->removeColumn('advertisment_serwis1_advertisment', 'title');
        $this->removeColumn('advertisment_serwis1_advertisment', 'slug');
        $this->removeColumn('advertisment_serwis1_advertisment', 'content');
        $this->removeColumn('advertisment_serwis2_advertisment', 'title');
        $this->removeColumn('advertisment_serwis2_advertisment', 'slug');
        $this->removeColumn('advertisment_serwis2_advertisment', 'content');
        $this->removeColumn('advertisment_serwis3_advertisment', 'title');
        $this->removeColumn('advertisment_serwis3_advertisment', 'slug');
        $this->removeColumn('advertisment_serwis3_advertisment', 'content');
    }
}