<?php

/**
 * Reference_DataTables_Adapter_ReferenceSerwis5
 *
 * @author Tomasz Kardas <kardi31@tlen.pl>
 */
class Media_DataTables_Adapter_Attachment extends Default_DataTables_Adapter_AdapterAbstract {
   
     public function getBaseQuery() {
        $q = $this->table->createQuery('a');
        $q->select('a.*');
        
         $q->addOrderBy('a.lft ASC');
        
        if($id = $this->request->getParam('id')) {
           $q->addWhere('root_id = ?',$id);
        }  
        
        $q->addWhere('a.level > 0');
        
        return $q;
    }
    
}

