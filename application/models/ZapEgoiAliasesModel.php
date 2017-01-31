<?php

class ZapEgoiAliasesModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "zap_egoi_aliases";
    }

   public function getAliases($ids = array()){
       $this->db->select('*');
       $this->db->from($this->table);
       //$this->db->join('zap_egoi_mapping', 'al.id = zap_egoi_mapping.alias_id');
       if(!empty($ids)){
           $this->db->where_not_in('id', $ids);
       }
       $query = $this->db->get();
       return $query->result();
   }
}