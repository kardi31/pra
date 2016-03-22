<?php

/**
 * Banner_DataTables_Adapter_BannerRight
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_DataTables_Adapter_Update extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->select('x.*');
        $q->leftJoin('x.Branches u');
        $q->andWhere('x.update_id IS NULL');
        return $q;
    }
}

