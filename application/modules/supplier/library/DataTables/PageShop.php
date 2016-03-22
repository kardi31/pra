<?php

/**
 * Page_DataTables_PageShop
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Page_DataTables_PageShop extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Page_DataTables_Adapter_PageShop';
    }
}

