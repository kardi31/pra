<?php

/**
 * Product_DataTables_Adapter_Attachment
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Product_DataTables_Adapter_Attachment extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('a');
        $q->select('a.*');
        $q->andWhere('a.product_id = ?', $this->request->getParam('id'));
        return $q;
    }
    
}

