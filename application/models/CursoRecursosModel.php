<?php

class CursoRecursosModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "curso_recursos";
    }

    public function getByCourseId($course_id = null, $resource_id = null) {
        if(!$course_id){
            return null;
        }
        $this->db->select("rec_cu.id as rec_cu_id, rec.id AS resource_id,
                                rec.valor AS resource_name")
                           ->from($this->table.' AS rec_cu')
                           ->join('material apoyo AS rec', 'rec_cu.idrecurso =  rec.id', 'left')
                           ->where('rec_cu.codigocurso', $course_id);
        if($resource_id){
            $this->db->where('rec_cu.idrecurso', $resource_id);
        }

        $this->db->order_by(2);
        $query = $this->db->get();

        return $query->result();
    }

    public function addResource($course_id = null, $resource_id = null) {
        if(empty($course_id) || empty($resource_id)){
            return null;
        }
        $data = array(
            'codigocurso' => $course_id,
            'idrecurso' => $resource_id
        );
        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }

    public function deleteResourceById($id = null) {
        if(empty($id)){
            return null;
        }
        $where = array(
            'id' => $id
        );        

        return $this->db->delete($this->table, $where);
    }

    public function get_count($course_id = null) {
        if(!$course_id){
            return null;
        }
        $query = $this->db->select("COUNT(*) AS resources_count")
            ->from($this->table)
            ->where('codigocurso', $course_id)
            ->get();
        return $query->row();
    }

}