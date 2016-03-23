<?php

/**
 * Newsletter_Model_Doctrine_Subscriber
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    Admi
 * @subpackage Newsletter
 * @author     Andrzej Wilczyński <and.wilczynski@gmail.com>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Newsletter_Model_Doctrine_Subscriber extends Newsletter_Model_Doctrine_BaseSubscriber
{
    public function getId() {
        return $this->_get('id');
    }
    
    public function getEmail() {
        return $this->_get('email');
    }
    
    public function setFirstName($firstName) {
	$this->_set('first_name', $firstName);
    }

    public function getFirstName() {
	return $this->_get('first_name');
    }

    public function setLastName($lastName) {
	$this->_set('last_name', $lastName);
    }

    public function getLastName() {
	return $this->_get('last_name');
    }
    
    public function setToken($token) {
	$this->_set('token', $token);
    }
    
    public function getToken() {
	return $this->_get('token');
    }
    
    public function setActive($active) {
	$this->_set('active', $active);
    }
}