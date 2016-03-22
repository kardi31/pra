<?php

/**
 * Banner_DataTables_Adapter_BannerRight
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Agent_DataTables_Adapter_Category extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->select('x.*');
//        $q->andWhere('b.level > ?', 0);
//        $q->addOrderBy('b.lft ASC');
        return $q;
    }
}

