<?php

/**
 * Order_DataTables_Adapter_Delivery
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Default_DataTables_Adapter_Message extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->leftJoin('x.Sends s');
        $q->select('x.*');
        $q->addSelect('s.*');
        return $q;
    }
}

