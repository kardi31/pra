<?php

/**
 * Slider_DataTables_Slide
 *
 * @author Michał Folga <michalfolga@gmail.com>
 */
class Review_DataTables_ReviewTemp extends Default_DataTables_DataTablesAbstract {
    
    public function getAdapterClass() {
        return 'Review_DataTables_Adapter_ReviewTemp';
    }
}

