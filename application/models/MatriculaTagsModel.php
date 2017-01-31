<?php

class MatriculaTagsModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "matricula_tags";
    }

    public function getTags($id = null){
        $this->db->select('mt.id AS enroll_tag_id, t.id AS tag_id, t.tag_name, t.hex_backcolor, t.hex_forecolor, nummatricula AS enroll_id');
        $this->db->from($this->table.' AS mt');
        $this->db->join('erp_tags AS t', 't.id = mt.id_tag', 'left');
        if($id) {
            $this->db->where('nummatricula', $id);
        }
        $this->db->order_by(1, 'DESC');
        $query = $this->db->get();

        return $query->result();
    }

    public function insertBatch($insert_data){
        if(empty($insert_data)){
            return null;
        }
        $query = $this->db->insert_batch($this->table, $insert_data);
        return $query;
    }



    public function deleteItem($enroll_id, $tag_id){
       return $this->delete($this->table, array('id_tag' => $tag_id, 'nummatricula' => $enroll_id));
    }

    public function deleteAllItems($enroll_id){
       return $this->delete($this->table, array('nummatricula' => $enroll_id));
    }

}