<?php

/**
 * Review_Model_Doctrine_CommentTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class Review_Model_Doctrine_CommentTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object Review_Model_Doctrine_CommentTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Review_Model_Doctrine_Comment');
    }
}