<?php

/**
 * Newsletter_DataTables_Message
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Newsletter_DataTables_Message extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Newsletter_DataTables_Adapter_Message';
    }
}

