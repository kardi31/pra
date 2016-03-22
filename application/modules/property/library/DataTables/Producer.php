<?php

/**
 * Product_DataTables_Producer
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Product_DataTables_Producer extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Product_DataTables_Adapter_Producer';
    }
}

