<?php

class ZapEgoiMappingModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "zap_egoi_mapping";
    }

   public function getMapping($id = null){
       $this->db->select('*');
       $this->db->from($this->table);
       if($id){
           $this->db->where('id', $id);
       }
       $query = $this->db->get();
       return $query->result();
   }

    public function insertData($insert_data){
        return $this->insert($this->table, $insert_data);

    }

    public function deleteItem($mapped_id = null){
        return $this->delete($this->table, array('id' => $mapped_id));
    }
    public function deleteAllItems(){
               $this->db->where('id !=', null);
        return $this->db->delete($this->table);
    }

    public function getMappedFiledsByTable($table_name){
        $this->db->select('als.field_name, als.field_type, als.table_name, mp.egoi_field, mp.egoi_list');
        $this->db->from($this->table.' AS mp');
        $this->db->join('zap_egoi_aliases AS als', 'als.id = mp.alias_id');
        $this->db->where('als.table_id', $table_name);
        $query = $this->db->get();

        return $query->result();
    }
}