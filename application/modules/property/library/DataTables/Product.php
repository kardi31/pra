<?php

/**
 * Product_DataTables_Product
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Product_DataTables_Product extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Product_DataTables_Adapter_Product';
    }
}

