<?php

/**
 * Banner_DataTables_Adapter_Ad
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class Banner_DataTables_Adapter_Ad extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('p');
        $q->select('p.*');
        $q->addSelect('pt.*');
        $q->leftJoin('p.Translation pt');
        return $q;
    }
}

