<?php

/**
 * Invoice_DataTables_Adapter_Invoice
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Staff_DataTables_Adapter_Staff extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->select('x.*');
        $q->addSelect('a.*');
        $q->leftJoin('x.Agent a');
        return $q;
    }
}

