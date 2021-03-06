<?php
/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Version2 extends Doctrine_Migration_Base
{
    public function up()
    {
        $this->dropTable('newsletter_group');
        $this->dropTable('newsletter_message');
        $this->dropTable('newsletter_sent');
        $this->dropTable('newsletter_subscriber');
        $this->dropTable('newsletter_subscriber_group');
        $this->changeColumn('job_course_name', 'id', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
        $this->changeColumn('job_course_profile', 'id', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
        $this->changeColumn('job_driving_license', 'id', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
        $this->changeColumn('job_job_position', 'id', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
        $this->changeColumn('job_job_position_level', 'id', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
        $this->changeColumn('job_job_profile', 'id', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
        $this->changeColumn('job_job_sector', 'id', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
        $this->changeColumn('job_job_type', 'id', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
        $this->changeColumn('job_language', 'id', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
        $this->changeColumn('job_language_level', 'id', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
        $this->changeColumn('job_offer', 'id', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
        $this->changeColumn('job_university', 'id', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
        $this->changeColumn('job_university_study', 'id', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
        $this->changeColumn('job_university_study_field', 'id', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
        $this->changeColumn('job_university_type', 'id', 'integer', '4', array(
             'primary' => '1',
             'autoincrement' => '1',
             ));
    }

    public function down()
    {
        $this->createTable('newsletter_group', array(
             'id' => 
             array(
              'primary' => '1',
              'autoincrement' => '1',
              'type' => 'integer',
              'length' => '4',
             ),
             'name' => 
             array(
              'type' => 'string',
              'length' => '255',
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
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_general_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('newsletter_message', array(
             'id' => 
             array(
              'primary' => '1',
              'autoincrement' => '1',
              'type' => 'integer',
              'length' => '4',
             ),
             'type' => 
             array(
              'type' => 'string',
              'length' => '128',
             ),
             'title' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'content' => 
             array(
              'type' => 'clob',
              'length' => '',
             ),
             'send_date' => 
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
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_general_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('newsletter_sent', array(
             'id' => 
             array(
              'primary' => '1',
              'autoincrement' => '1',
              'type' => 'integer',
              'length' => '6',
             ),
             'message_id' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'subscriber_id' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'group_id' => 
             array(
              'type' => 'integer',
              'length' => '4',
             ),
             'send_at' => 
             array(
              'type' => 'timestamp',
              'length' => '25',
             ),
             'sent' => 
             array(
              'type' => 'boolean',
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
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_general_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('newsletter_subscriber', array(
             'id' => 
             array(
              'primary' => '1',
              'autoincrement' => '1',
              'type' => 'integer',
              'length' => '4',
             ),
             'name' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'lastname' => 
             array(
              'type' => 'string',
              'length' => '255',
             ),
             'email' => 
             array(
              'type' => 'string',
              'length' => '255',
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
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'id',
             ),
             'collate' => 'utf8_general_ci',
             'charset' => 'utf8',
             ));
        $this->createTable('newsletter_subscriber_group', array(
             'subscriber_id' => 
             array(
              'primary' => '1',
              'type' => 'integer',
              'length' => '4',
             ),
             'group_id' => 
             array(
              'primary' => '1',
              'type' => 'integer',
              'length' => '4',
             ),
             ), array(
             'type' => 'MyISAM',
             'indexes' => 
             array(
             ),
             'primary' => 
             array(
              0 => 'subscriber_id',
              1 => 'group_id',
             ),
             'collate' => 'utf8_general_ci',
             'charset' => 'utf8',
             ));
    }
}