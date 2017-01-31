<?php

class ErpCustomFieldsModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "erp_custom_fields";
    }

    public function getFields($id = null){
        $this->db->select('*');
        $this->db->from($this->table);
        if($id) {
            $this->db->where('id', $id);
        }
        $query = $this->db->get();
        if($id) {
            return $query->row();
        }else{
            return $query->result();
        }
    }
     public function getFieldsList($form_type = null){
        $this->db->select('*');
        $this->db->from($this->table);
        if($form_type) {
            $this->db->where('form_type', $form_type);
        }
        $query = $this->db->get();
        
        return $query->result_array();
        
    }


    public function update_status($id, $status){
       return $this->update($this->table, $status, array('id' => $id));
   }

    public function getFieldsForfilter($field_ids = array()) {
        $this->db->select('id, tag_name AS text');
        $this->db->from($this->table);
        if(!empty($tag_ids)){
            $this->db->where_not_in('id', $tag_ids);
        }
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getFieldsForfilterBytable($where_not_in = array()){
        $this->db->select('id AS value, field_name AS text');
        $this->db->from($this->table);
        if(!empty($where_not_in)) {
            $this->db->where("id NOT IN ($where_not_in)");
        }
        $query = $this->db->get();
        return $query->result();
    }


    public function insertField($insert_data){
        //print_r($insert_data);
        return $this->insert($this->table, $insert_data);
       
    }

    public function updateField($update_data, $field_id){
        return $this->update($this->table, $update_data, array('id' => $field_id));
    }

    public function deleteFieldWithRelations($field_id){
        if($this->delete($this->table, array('id' => $field_id))){
            
            return true;
        }else{
            return false;
        }
    }

    public function getNotExistField($ids, $foreign_id, $table_name, $foreign_key){
        $this->db->select('jt.id AS current_table_tag_id, '.$foreign_key.', t.id AS tag_id, t.tag_name, t.hex_backcolor, t.hex_forecolor');
        $this->db->from($this->table.' AS t');
        $this->db->join("$table_name AS jt", 't.id = jt.id_tag AND jt.'.$foreign_key."='".$foreign_id."'", 'left');
        $this->db->where_in('t.id', $ids);
        $query = $this->db->get();
        return $query->result();
    }
}