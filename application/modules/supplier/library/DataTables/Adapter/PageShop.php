<?php

/**
 * Page_DataTables_Adapter_PageShop
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Page_DataTables_Adapter_PageShop extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->select('x.*');
        $q->addSelect('t.*');
        $q->leftJoin('x.Translation t');
        $q->addOrderBy('x.type DESC, x.id');
        return $q;
    }
}
