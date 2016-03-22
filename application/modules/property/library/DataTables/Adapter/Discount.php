<?php

/**
 * Product_DataTables_Adapter_Discount
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Product_DataTables_Adapter_Discount extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->select('x.*');
        return $q;
    }
}

