<?php

class ClientesSeguiModel extends MagaModel {

    public function __construct() {
        parent::__construct();
        $this->table = "clientes_segui";
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
            FROM clientes_segui
            WHERE ccodcli = '".$id."'
            AND id_user = '".$user_id."'
            ORDER BY 2 DESC
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