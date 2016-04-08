<?php

/**
 * News_DataTables_adapter_NewsSerwis1
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Branch_DataTables_Adapter_BranchShort extends Default_DataTables_Adapter_AdapterAbstract {
    
    public function getBaseQuery() {
        
        $lat = $this->request->getParam('lat');
        $lng = $this->request->getParam('lng');
        $categories = $this->request->getParam('categories');
        $radius = $this->request->getParam('radius');
        $q = $this->table->createQuery('x');
        $q->leftJoin('x.Agent a');
        $q->leftJoin('a.Categories c');
        if($lat){
            $q->addWhere('get_distance_in_miles_between_geo_locations('.$lat.','.$lng.',lat,lng) < '.$radius);
            if($categories){
                $q->whereIn('c.id',$categories);
            }
        }
        $q->limit(50);
        return $q;
    }
}
    
