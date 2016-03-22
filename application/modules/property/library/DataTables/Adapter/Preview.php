<?php

/**
 * Product_DataTables_Adapter_Preview
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Product_DataTables_Adapter_Preview extends Default_DataTables_Adapter_AdapterAbstract {

    public function getBaseQuery() {
        $q = $this->table->createQuery('p');
        $q->addSelect('p.*');
        $q->addSelect('pro.*');
        $q->addSelect('cat.*');
        $q->leftJoin('p.Producer pro');
        $q->leftJoin('p.Categories cat');
        return $q;
    }
    
}

