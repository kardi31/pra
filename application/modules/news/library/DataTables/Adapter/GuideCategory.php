<?php

/**
 * News_DataTables_adapter_NewsSerwis1
 *
 * @author Tomasz Kardas <biuro@kardimobile.pl>
 */
class News_DataTables_Adapter_GuideCategory extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->leftJoin('x.Translation xt');
        return $q;
    }
}

