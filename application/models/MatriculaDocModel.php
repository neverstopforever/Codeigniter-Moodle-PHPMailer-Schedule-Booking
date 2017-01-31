<?php

class MatriculaDocModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "matricula_doc";
    }

    public function getByEnrollId($id) {
        $query = $this->db->select('id, nombre AS name, documento, doclink, visible, (SELECT count(*) FROM '.$this->table.' WHERE  nummatricula='.$id.') AS doc_count')
                           ->from($this->table)
                           ->where('nummatricula', $id)
                           ->get();

        return $query->result();
    }

 public function getFieldsList($form_type = null){
        $this->db->select('*');
        $this->db->from('erp_custom_fields');
        if($form_type) {
            $this->db->where('form_type', $form_type);
        }
        $query = $this->db->get();
        
        return $query->result_array();
        
    }
}