<?php

/**
 * Slider_DataTables_Adapter_Slide
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Review_DataTables_Adapter_ReviewTemp extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->leftJoin('x.Branch b');
        $q->leftJoin('x.Agent a');
        
        return $q;
    }
}
