<?php

/**
 * Default_Model_Doctrine_SettingTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Default_Model_Doctrine_SettingTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object Default_Model_Doctrine_SettingTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Default_Model_Doctrine_Setting');
    }
}