<?php

/**
 * News_DataTables_NewsSerwis1
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class District_DataTables_People extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'District_DataTables_Adapter_People';
    }
}

