<?php

/**
 * Newsletter_DataTables_Adapter_Subscriber
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Newsletter_DataTables_Adapter_Subscriber extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('s');
        $q->select('s.*');
        return $q;
    }
}

