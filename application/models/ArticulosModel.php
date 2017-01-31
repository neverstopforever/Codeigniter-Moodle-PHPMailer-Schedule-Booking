<?php

class ArticulosModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "articulos";
    }

    public function getByGroupId($id){
       $query = $this->db->select('Referencia` AS id,
                                   `Descripcion` AS title ')
                         ->from($this->table)
                         ->where("Referencia` NOT IN (SELECT codigomaterial FROM gmateriall WHERE codigogrupo = '".$id."')")
                         ->order_by('2')
                         ->get();
        return $query->result();
    }

    public function getByCourseId($course_id = null){
        if(empty($course_id)){
            return false;
        }
       $query = "SELECT
                  art.referencia AS book_id,
                  art.descripcion AS book_name,
                  art.unidades AS stock
                FROM
                  articulos AS art
                WHERE art.referencia NOT IN
                      (SELECT
                         `codigoart`
                       FROM
                         curso_articulos
                       WHERE `codigocurso` = '".$course_id."')
                ;";
        return $this->selectCustom($query);
    }

    public function getById($id){
        $query = $this->db->select('Referencia` AS id,
                                   `Descripcion` AS title ')
            ->from($this->table)
            ->where('Referencia', $id)
            ->order_by('2')
            ->get();
        return $query->row();
    }


}