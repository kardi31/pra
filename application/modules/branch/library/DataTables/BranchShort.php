<?php

/**
 * News_DataTables_NewsSerwis1
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_DataTables_BranchShort extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Branch_DataTables_Adapter_BranchShort';
    }
}

