<?php

/**
 * News_DataTables_NewsSerwis1
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class News_DataTables_Group extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'News_DataTables_Adapter_Group';
    }
}
