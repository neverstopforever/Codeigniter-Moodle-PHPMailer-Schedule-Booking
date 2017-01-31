<?php

class CursoDocModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "curso_doc";
    }

    public function getByCourseId($course_id = null) {
        if(!$course_id){
            return null;
        }
        $query = $this->db->select("id, codigocurso AS course_id, nombre AS name, documento, doclink, visible, (SELECT count(*) FROM ".$this->table." WHERE  codigocurso='".$course_id."') AS doc_count")
                           ->from($this->table)
                           ->where('codigocurso', $course_id)
                           ->get();

        return $query->result();
    }


    public function get_count($course_id = null) {
        if(!$course_id){
            return null;
        }
        $query = $this->db->select("COUNT(*) AS doc_count")
                           ->from($this->table)
                           ->where('codigocurso', $course_id)
                           ->get();
        return $query->row();
    }


}