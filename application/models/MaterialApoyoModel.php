<?php

class MaterialApoyoModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = 'material apoyo';
    }

    public function getByCourseId($course_id = null){
        if(empty($course_id)){
            return false;
        }
       $query = "SELECT
                  id AS resource_id,
                  valor AS resource_name
                FROM `material apoyo`
                WHERE id NOT IN
                      (
                        SELECT idrecurso
                        FROM curso_recursos
                        WHERE codigocurso = '".$course_id."'
                      )
                ORDER BY 2
                ;";
        return $this->selectCustom($query);
    }

    public function getById($id = null){
        if(empty($id)){
            return false;
        }
        $query = "SELECT * FROM `material apoyo` WHERE `id` = '".$id."';";
        return $this->selectCustom($query);
    }
}