<?php

/**
 * Advertisment_DataTables_adapter_AdvertismentSerwis1
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class Advertisment_DataTables_Adapter_Group extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        return $q;
    }
}

