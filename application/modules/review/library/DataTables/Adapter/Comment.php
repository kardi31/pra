<?php

/**
 * Slider_DataTables_Adapter_Slide
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Review_DataTables_Adapter_Comment extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        $q = $this->table->createQuery('x');
        $q->leftJoin('x.Review r');
        
        return $q;
    }
}
