<?php

/**
 * Advertisment_DataTables_adapter_AdvertismentSerwis1
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class Advertisment_DataTables_Adapter_Advertisment extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->leftJoin('x.Translation xt');
        $q->leftJoin('x.Category c');
        $q->leftJoin('x.Group g');
        $q->leftJoin('x.UserCreated uc');
        
       $serviceBroker = MF_Service_ServiceBroker::getInstance();
       $user = $serviceBroker->getService('User_Service_Auth')->getAuthenticatedUser();
       if($user->role=="redaktor"):
           foreach($user['Roles'] as $roles):
               $q->orWhere('c.slug = ?',$roles['slug']);
           endforeach;
       endif;
        return $q;
    }
}

