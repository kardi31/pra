<?php

/**
 * Newsletter_DataTables_Group
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Newsletter_DataTables_Group extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Newsletter_DataTables_Adapter_Group';
    }
}

