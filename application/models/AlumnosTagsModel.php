<?php

class AlumnosTagsModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "alumnos_tags";
    }

    public function getTags($id = null){
        $this->db->select('st.id AS student_tag_id, t.id AS tag_id, t.tag_name, t.hex_backcolor, t.hex_forecolor, ccodcli AS student_id');
        $this->db->from($this->table.' AS st');
        $this->db->join('erp_tags AS t', 't.id = st.id_tag', 'left');
        if($id) {
            $this->db->where('ccodcli', $id);
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



    public function deleteItem($studnt_id, $tag_id){
       return $this->delete($this->table, array('id_tag' => $tag_id, 'ccodcli' => $studnt_id));
    }

    public function deleteAllItems($student_id){
       return $this->delete($this->table, array('ccodcli' => $student_id));
    }

}