<?php

class ErpMappingOptionModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "erp_mapping_options";
    }

    public function getImportModels($where = array()) {       

        $this->db->select("*");
        $this->db->from($this->table);
        if(!empty($where)) {
            $this->db->where($where);
        }
        $this->db->order_by(2);
        $query =  $this->db->get();

        return $query->result();
    }   

    public function getFieldsById($id) {  
        
        if(empty($id)){
            return false;
        }

        $this->db->select("mo.id as mo_id, mo.title as mo_title, ma.*");
        $this->db->from($this->table.' as mo');
        $this->db->join('erp_mapping_alias as ma', 'ma.table = mo.table', 'left');
        $this->db->where('mo.id', $id);
        $this->db->where('ma.hidden !=', 1);
        $query =  $this->db->get();

        return $query->result();
    }   
}