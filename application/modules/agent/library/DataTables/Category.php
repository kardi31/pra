<?php

/**
 * Banner_DataTables_Banner
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_DataTables_Category extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Agent_DataTables_Adapter_Category';
    }
}

