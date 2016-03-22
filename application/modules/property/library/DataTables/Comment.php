<?php

/**
 * Product_DataTables_Comment
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Product_DataTables_Comment extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Product_DataTables_Adapter_Comment';
    }
}

