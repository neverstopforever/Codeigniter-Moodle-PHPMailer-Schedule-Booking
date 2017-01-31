<?php

class PresupuestoSeguiModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "presupuesto_segui";
    }

    public function getFollowUp($id = null, $user_id = null) {

        if (!$id) {
            return null;
        }

        $query = "
            SELECT
            id,
            fecha AS `date`,
            titulo AS `subject`,
            comentarios AS comments
            FROM presupuesto_segui
            WHERE NumPresupuesto = '".$id."'";
        
//        if($user_id){
//            $query .=   " AND id_user = '".$user_id."'";
//        }
        
        $query .= " ORDER BY 2 DESC
            ";

        return $this->selectCustom($query);
    }



    public function getSeguimiento($id = null, $user_id = null) {

        if (!$id) {
            return null;
        }

        $query = "
            SELECT
            id,
            fecha,
            titulo,
            comentarios
            FROM presupuesto_segui
            WHERE NumPresupuesto = '".$id."'";

//        if($user_id){
            $query .=   " AND id_user = '".$user_id."'";
//        }

        $query .= " ORDER BY 2 DESC
            ";
        return $this->selectCustom($query);
    }

    public function insertFollowUp($dataArray){
       return $this->insert($this->table, $dataArray);
    }

    public function deleteFollowUp($id){
        return $this->delete($this->table, array('id' => $id));
    }
}