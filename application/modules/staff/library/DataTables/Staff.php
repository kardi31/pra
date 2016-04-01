<?php

/**
 * Invoice_DataTables_Invoice
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Staff_DataTables_Staff extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Staff_DataTables_Adapter_Staff';
    }
}

