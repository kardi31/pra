<?php

/**
 * Advertisment_DataTables_AdvertismentSerwis1
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class Advertisment_DataTables_Group extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Advertisment_DataTables_Adapter_Group';
    }
}

