<?php

class PresupuestoTagsModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "presupuesto_tags";
    }

    public function getTags($id = null){
        $this->db->select('pt.id AS prospect_tag_id, t.id AS tag_id, t.tag_name, t.hex_backcolor, t.hex_forecolor, numpresupuesto AS prospect_id');
        $this->db->from($this->table.' AS pt');
        $this->db->join('erp_tags AS t', 't.id = pt.id_tag', 'left');
        if($id) {
            $this->db->where('numpresupuesto', $id);
        }
        $this->db->order_by(1, 'DESC');
        $query = $this->db->get();

        return $query->result();
    }
    public function getAllTags(){
        $this->db->select('id, tag_name as text');
        $this->db->from('erp_tags');
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



    public function deleteItem($client_id, $tag_id){
       return $this->delete($this->table, array('id_tag' => $tag_id, 'numpresupuesto' => $client_id));
    }

    public function deleteAllItems($client_id){
       return $this->delete($this->table, array('numpresupuesto' => $client_id));
    }

}