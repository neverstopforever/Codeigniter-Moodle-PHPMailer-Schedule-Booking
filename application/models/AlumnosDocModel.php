<?php

class AlumnosDocModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "alumnos_doc";
    }

    public function getByStudentId($id) {
        $query = $this->db->select('id, nombre AS name, documento, doclink, visible, (SELECT count(*) FROM '.$this->table.' WHERE  idalumno='.$id.') AS doc_count')
                           ->from($this->table)
                           ->where('idalumno', $id)
                           ->get();

        return $query->result();
    }


}