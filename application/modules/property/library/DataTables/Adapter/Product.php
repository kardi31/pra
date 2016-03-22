<?php

/**
 * Product_DataTables_Adapter_Product
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Product_DataTables_Adapter_Product extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('pro');
        $q->select('pro.*');
        $q->addSelect('pt.*');
        $q->addSelect('pr.*');
        $q->addSelect('prt.*');
        $q->addSelect('c.*');
        $q->addSelect('ct.*');
        $q->leftJoin('pro.Translation pt');
        $q->leftJoin('pro.Categories c');
        $q->leftJoin('c.Translation ct');
        $q->leftJoin('pro.Producer pr');
        $q->leftJoin('pr.Translation prt');
        return $q;
    }
}
