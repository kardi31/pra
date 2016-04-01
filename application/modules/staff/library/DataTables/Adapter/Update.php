<?php

/**
 * Invoice_DataTables_Adapter_Invoice
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Staff_DataTables_Adapter_Update extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->select('x.*');
        $q->addSelect('s.*');
        $q->addSelect('a.*');
        $q->leftJoin('x.Staff s');
        $q->leftJoin('s.Agent a');
        return $q;
    }
}

