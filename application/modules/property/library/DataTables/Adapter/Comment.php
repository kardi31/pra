<?php

/**
 * Product_DataTables_Adapter_Comment
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Product_DataTables_Adapter_Comment extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('c');
        $q->addSelect('c.*');
        $q->addSelect('pro.*');
        $q->addSelect('pt.*');
        $q->addSelect('u.*');
        $q->leftJoin('c.Product pro');
        $q->leftJoin('pro.Translation pt');
        $q->leftJoin('c.User u');
        return $q;
    }
}