<?php

/**
 * News_DataTables_adapter_NewsSerwis1
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_DataTables_Adapter_Branch extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->leftJoin('x.Translation xt');
        $q->leftJoin('x.Agent a');
        return $q;
    }
}

