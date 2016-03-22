<?php

/**
 * Newsletter_DataTables_Adapter_Message
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Newsletter_DataTables_Adapter_Message extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('m');
        $q->select('m.*');
        return $q;
    }
}

