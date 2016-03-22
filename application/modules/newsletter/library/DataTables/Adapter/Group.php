<?php

/**
 * Newsletter_DataTables_Adapter_Group
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Newsletter_DataTables_Adapter_Group extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('g');
        $q->select('g.*');
        return $q;
    }
}

