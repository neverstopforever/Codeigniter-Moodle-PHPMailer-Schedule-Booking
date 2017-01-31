<?php

class PresupuestolModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "presupuestol";
    }

    public function getCourses($id) {
        $query = $this->db->select('id, codigocurso AS ref, Descripcion AS description, Horas AS hours, precio AS price, TIPO')
                          ->from($this->table)
                          ->where('NumPresupuesto', $id)
                          ->get();

        return $query->result();
    }

    public function deleteItem($id){
       return $this->delete($this->table, array('id' => $id));
    }

    public function getExistCourses($id){
        $query = $this->db->select('id, codigocurso AS course_id')
                          ->from($this->table)
                          ->where('NumPresupuesto', $id)
                          ->get();

        return $query->result();
    }

    public function insertData($courses){
        return $this->db->insert_batch($this->table, $courses);
    }

}