<?php

class ScResourcePostIndividualModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "sc_resource_post_individual";
    }

    public function get_post($iid,$teacher_id, $student_id){
        $sql = "SELECT $this->table.*, profesor.nombre FROM $this->table LEFT join profesor on "
            . "$this->table.teacher_id = profesor.INDICE WHERE "
            . "$this->table.resource_individual_id = '$iid' AND "
            . "$this->table.student_id = '$student_id' AND "
            . "$this->table.teacher_id= '$teacher_id'";
        $query = $this->db->query($sql);
        return $query->result();
    }

   
}