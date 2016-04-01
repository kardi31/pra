<?php

/**
 * Article
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Advertisment_DataTables_Adapter_Advertisment extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->select('x.*');
        $q->addSelect('xt.*');
        $q->addSelect('c.*');
        $q->addSelect('g.*');
        $q->addSelect('ct.*');
        $q->addSelect('gt.*');
        $q->leftJoin('x.Translation xt');
        $q->leftJoin('x.Category c');
        $q->leftJoin('c.Translation ct');
        $q->leftJoin('c.Group g');
        $q->leftJoin('g.Translation gt');
        return $q;
    }
}

