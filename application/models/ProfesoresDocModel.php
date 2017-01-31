<?php

class ProfesoresDocModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "profesor_doc";
    }

    public function getDocuments($teacher_id) {
        $query = $this->db->select('id, fecha, nombre AS name, doclink, IF(visible IS NULL OR visible = 0,"NO","SI") AS visible')
                           ->from($this->table)
                           ->where('idprofesor', $teacher_id)
                           ->get();

        return $query->result();
    }

    public function deleteDocuments($document_id){
        return $this->delete($this->table, array('id' => $document_id));
    }
}