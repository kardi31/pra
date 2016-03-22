<?php

/**
 * Reference_DataTables_ReferenceSerwis7
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Media_DataTables_Attachment extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Media_DataTables_Adapter_Attachment';
    }
}

