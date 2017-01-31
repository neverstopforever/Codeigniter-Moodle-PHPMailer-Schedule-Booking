<?php

class ApdateBatchModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "update_batch";
    }

    public function getCsqls(){
        $query = $this->db->select('csql')
                 ->from($this->table)
                 ->where('active', '1')
                 ->get();

        return $query->result();
    }
    
    public function executingQuery($csql){
        return $this->custom_sql($csql);
    }

    

}