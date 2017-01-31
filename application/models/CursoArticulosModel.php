<?php

class CursoArticulosModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "curso_articulos";
    }

    public function getByCourseId($course_id = null, $book_id = null) {
        if(!$course_id){
            return null;
        }
        $this->db->select("cua.id as cua_id, art.referencia AS book_id,
                                    art.descripcion AS book_name,
                                    art.unidades AS stock")
                           ->from($this->table.' as cua')
                           ->join('articulos AS art', 'cua.codigoart = art.referencia', 'left')
                           ->where('cua.codigocurso', $course_id);
        if($book_id){
            $this->db->where('cua.codigoart', $book_id);
        }

        $query = $this->db->get();

        return $query->result();
    }

    public function addBook($course_id = null, $book_id = null) {
        if(empty($course_id) || empty($book_id)){
            return null;
        }
        $data = array(
            'codigocurso' => $course_id,
            'codigoart' => $book_id
        );
        $this->db->insert($this->table, $data);

        return $this->db->insert_id();
    }

    public function deleteBookById($id = null) {
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
        $query = $this->db->select("COUNT(*) AS books_count")
            ->from($this->table)
            ->where('codigocurso', $course_id)
            ->get();
        return $query->row();
    }


}