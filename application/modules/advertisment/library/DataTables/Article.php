<?php

/**
 * Article
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Advertisment_DataTables_Article extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Advertisment_DataTables_Adapter_Article';
    }
}

