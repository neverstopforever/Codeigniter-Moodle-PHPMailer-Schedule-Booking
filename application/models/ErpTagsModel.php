<?php

class ErpTagsModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "erp_tags";
    }

    public function getTags($id = null){
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

    public function getTagsForfilter($tag_ids = array()){
        $this->db->select('id, tag_name AS text');
        $this->db->from($this->table);
        if(!empty($tag_ids)){
            $this->db->where_not_in('id', $tag_ids);
        }
        $query = $this->db->get();
        return $query->result();
    }
    public function getTagsForfilterBytable($where_not_in = array()){
        $this->db->select('id AS value, tag_name AS text');
        $this->db->from($this->table);
        if(!empty($where_not_in)) {
            $this->db->where("id NOT IN ($where_not_in)");
        }
        $query = $this->db->get();
        return $query->result();
    }


    public function insertItem($insert_data){
        return $this->insert($this->table, $insert_data);
    }

    public function updateItem($update_data, $tag_id){
        return $this->update($this->table, $update_data, array('id' => $tag_id));
    }

    public function deleteItemWithRelations($tag_id){
        if($this->delete($this->table, array('id' => $tag_id))){
            $this->delete('alumnos_tags', array('id_tag' => $tag_id));
            $this->delete('presupuesto_tags', array('id_tag' => $tag_id));
            $this->delete('matricula_tags', array('id_tag' => $tag_id));
            return true;
        }else{
            return false;
        }
    }

    public function getNotExistTags($ids, $foreign_id, $table_name, $foreign_key){
        $this->db->select('jt.id AS current_table_tag_id, '.$foreign_key.', t.id AS tag_id, t.tag_name, t.hex_backcolor, t.hex_forecolor');
        $this->db->from($this->table.' AS t');
        $this->db->join("$table_name AS jt", 't.id = jt.id_tag AND jt.'.$foreign_key."='".$foreign_id."'", 'left');
        $this->db->where_in('t.id', $ids);
        $query = $this->db->get();
        return $query->result();
    }
}